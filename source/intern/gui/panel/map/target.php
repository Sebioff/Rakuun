<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Intern_GUI_Panel_Map_Target extends GUI_Panel {
	const STATE_PREPARING = 1;
	const STATE_REVIEWING = 2;
	
	private $user = null;
	private $cityX = 0;
	private $cityY = 0;
	private $army = null;
	
	public function __construct($name, Rakuun_DB_User $user = null, $cityX = 0, $cityY = 0) {
		parent::__construct($name);
		$this->user = $user;
		$this->cityX = $cityX;
		$this->cityY = $cityY;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/target.tpl');
		$this->addPanel($target = new Rakuun_GUI_Control_UserSelect('target', $this->user, 'Ziel'));
		$this->addPanel($targetX = new GUI_Control_DigitBox('target_x', $this->cityX, 'X', 0, Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH - 1));
		$this->addPanel($targetY = new GUI_Control_DigitBox('target_y', $this->cityY, 'Y', 0, Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT - 1));
		$this->addPanel(new GUI_Panel_Label('target_coords_label', $this->targetX, 'Koordinaten'));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_UnitInput('unit_input'));
		$spydrone = Rakuun_Intern_Production_Factory::getUnit('spydrone');
		if ($spydrone->getAmount() > 0) {
			$this->addPanel(new GUI_Control_DigitBox($spydrone->getInternalName(), 0, $spydrone->getName(), 0, $spydrone->getAmount()));
			$this->addPanel(new Rakuun_GUI_Panel_Info('spy_label', 'Spionagekraft', 'Je mehr Sonden zum Gegner geschickt werden, desto größer ist die Wahrscheinlichkeit, dass die Sonden unversehrt und mit kompletten Bericht zurückkehren.'));
		}
		$cloakedSpydrone = Rakuun_Intern_Production_Factory::getUnit('cloaked_spydrone');
		if ($cloakedSpydrone->getAmount() > 0) {
			$this->addPanel(new GUI_Control_DigitBox($cloakedSpydrone->getInternalName(), 0, $cloakedSpydrone->getName(), 0, $cloakedSpydrone->getAmount()));
		}
		$this->addPanel(new GUI_Control_CheckBox('destroy_buildings'));
		$this->addPanel($ironPriority = new GUI_Control_RadioButtonList('iron_priority', 'Priorität Eisen'));
		$ironPriority->addItem('Niedrig', 1, true);
		$ironPriority->addItem('Mittel', 2, false);
		$ironPriority->addItem('Hoch', 3, false);
		$ironPriority->addClasses('rakuun_map_target_priorities');
		$this->addPanel($berylliumPriority = new GUI_Control_RadioButtonList('beryllium_priority', 'Priorität Beryllium'));
		$berylliumPriority->addItem('Niedrig', 1, true);
		$berylliumPriority->addItem('Mittel', 2, false);
		$berylliumPriority->addItem('Hoch', 3, false);
		$berylliumPriority->addClasses('rakuun_map_target_priorities');
		$this->addPanel($energyPriority = new GUI_Control_RadioButtonList('energy_priority', 'Priorität Energie'));
		$energyPriority->addItem('Niedrig', 1, true);
		$energyPriority->addItem('Mittel', 2, false);
		$energyPriority->addItem('Hoch', 3, false);
		$energyPriority->addClasses('rakuun_map_target_priorities');
		$this->addPanel(new Rakuun_GUI_Panel_Info('destroy_buildings_label', 'Gebäude zerstören', 'Je größer die Angriffskraft, desto größer die Wahrscheinlichkeit, dass eine Stufe eines Gebäudes zerstört wird. Die maximale Wahrscheinlichkeit beträgt '.Rakuun_Cronjob_Script_Fight::DESTRUCTION_MAX_PROBABILITY.'% und kann mit einer Angriffskraft von '.Rakuun_Cronjob_Script_Fight::DESTRUCTION_NEEDED_FORCE_FOR_MAX.' erreicht werden. Gegen Feinde, mit denen man sich im Krieg befindet, wird nur die Hälfte dessen benötigt.'));
		$this->addPanel($state = new GUI_Control_HiddenBox('state', self::STATE_PREPARING));
		if (Rakuun_GameSecurity::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_GameSecurity::PRIVILEGE_PARTICIPATE_IN_FIGHTS))
			$this->addPanel(new GUI_Control_SubmitButton('submit', 'Vorbereiten...'));
		else
			$this->addPanel(new GUI_Panel_Text('submit', 'Fehlende Berechtigung zum Kämpfen'));
	}
	
	public function onSubmit() {
		$targetX = 0;
		$targetY = 0;
		$user = Rakuun_User_Manager::getCurrentUser();
		
		DB_Connection::get()->beginTransaction();
		$options = array();
		$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
		$userUnits = Rakuun_DB_Containers::getUnitsContainer()->selectByUserFirst($user, $options);
		
		$sendedUnits = $this->unitInput->getArmy($userUnits);
		
		if ($user->buildings->militaryBase == 0) {
			$this->addError('Du brauchst einen Militärstützpunkt, um deine Armee loszuschicken');
		}
		
		if ($user->isInNoob()) {
			$this->addError('Du kannst keine Angriffe starten, so lange du dich im Noobschutz befindest.');
		}
		
		if (empty($sendedUnits) && (!$this->hasPanel('spydrone') || $this->spydrone->getValue() == 0) && (!$this->hasPanel('cloaked_spydrone') || $this->cloakedSpydrone->getValue() == 0)) {
			$this->addError('Keine Einheiten ausgewählt.');
		}
		
		if (!empty($sendedUnits) && (($this->hasPanel('spydrone') && $this->spydrone->getValue() > 0) || ($this->hasPanel('cloaked_spydrone') && $this->cloakedSpydrone->getValue() > 0))) {
			$this->addError('Einheiten und Sonden können nicht zusammen verschickt werden.');
		}
		
		$targetUser = $this->getTargetUser();
		
		if ($targetUser) {
			$targetX = $targetUser->cityX;
			$targetY = $targetUser->cityY;
			
			if ($targetUser->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK()) {
				$this->addError('Du kannst dich nicht selbst angreifen!');
			}
			
			if ($targetUser->isLocked() && !$targetUser->isYimtay) {
				$this->addError('Dieser Spieler ist gesperrt und kann nicht angegriffen werden');
			}
			
			// noobprotection only if it's gonna be an attack with units
			if (!empty($sendedUnits)) {
				if ($targetUser->isInNoob()) {
					$this->addError('Der Spieler befindet sich im Noobschutz');
				}

				if ($this->destroyBuildings->getSelected() && !$targetUser->canBeBashed(Rakuun_User_Manager::getCurrentUser())) {
					$this->addError(sprintf('Der Spieler hat weniger als %d%% oder mehr als %d%% deiner eigenen Punktzahl, daher können seine Gebäude nicht zerstört werden.', RAKUUN_NOOB_SECURE_PERCENTAGE * 100, 100 / RAKUUN_NOOB_SECURE_PERCENTAGE));
				}
			}
			
			if (!Rakuun_GameSecurity::get()->hasPrivilege($targetUser, Rakuun_GameSecurity::PRIVILEGE_PARTICIPATE_IN_FIGHTS)) {
				$this->addError('Dieser Spieler kann nicht an Kämpfen teilnehmen.');
			}
		}
		else {
			$targetX = $this->targetX->getValue();
			$targetY = $this->targetY->getValue();
		}
		
		if ($this->hasErrors()) {
			$this->state->setValue(self::STATE_PREPARING);
			$this->submit->setValue('Vorbereiten...');
			DB_Connection::get()->rollback();
			return;
		}
		
		$armyTechnologies = new DB_Record();
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			$armyTechnologies->{$technology->getInternalName()} = $technology->getLevel();
		}
		Rakuun_DB_Containers::getArmiesTechnologiesContainer()->save($armyTechnologies);
		
		$army = new Rakuun_DB_Army();
		$army->user = Rakuun_User_Manager::getCurrentUser();
		$army->positionX = $army->user->cityX;
		$army->positionY = $army->user->cityY;
		$army->target = $targetUser;
		$army->targetX = $targetX;
		$army->targetY = $targetY;
		$army->technologies = $armyTechnologies;
		$army->tick = time();
		$army->destroyBuildings = $this->destroyBuildings->getSelected();
		$army->ironPriority = $this->ironPriority->getValue();
		if (!$army->ironPriority)
			$army->ironPriority = 1;
		$army->berylliumPriority = $this->berylliumPriority->getValue();
		if (!$army->berylliumPriority)
			$army->berylliumPriority = 1;
		$army->energyPriority = $this->energyPriority->getValue();
		if (!$army->energyPriority)
			$army->energyPriority = 1;
			
		$army->fightingSequence = $army->user->units->attackSequence;
		
		// update home unit amounts
		if ($this->hasPanel('spydrone'))
			$sendedUnits['spydrone'] = $this->spydrone->getValue();
		if ($this->hasPanel('cloaked_spydrone'))
			$sendedUnits['cloaked_spydrone'] = $this->cloakedSpydrone->getValue();
		foreach ($sendedUnits as $unitname => $unitamount) {
			$army->{Text::underscoreToCamelCase($unitname)} = $unitamount;
			$userUnits->{Text::underscoreToCamelCase($unitname)} -= $unitamount;
		}
		
		$army->speedMultiplier = 1;
		
		$warpgateDatabase = new Rakuun_User_Specials_Database($army->user, Rakuun_User_Specials::SPECIAL_DATABASE_BLUE);
		if ($warpgateDatabase->hasSpecial())
			$army->speedMultiplier -= $warpgateDatabase->getEffectValue();
			
		if ($army->speedMultiplier < 0.01)
			$army->speedMultiplier = 0.01;
		
		Rakuun_DB_Containers::getArmiesContainer()->save($army);
		
		$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
		$path = $pathCalculator->getPath();
		
		if (!$path) {
			$this->addError('Es gibt keinen Weg zu den Zielkoordinaten');
			DB_Connection::get()->rollback();
			return;
		}
		
		$this->army = $army;
		
		if ($this->state->getValue() == self::STATE_PREPARING) {
			$this->state->setValue(self::STATE_REVIEWING);
			$this->submit->setValue('Abschicken');
			$this->target->addClasses('hidden');
			$this->targetX->addClasses('hidden');
			$this->targetY->addClasses('hidden');
			return;
		}
		else {
			$this->state->setValue(self::STATE_PREPARING);
			$this->target->setDefaultValue($this->target->getValue());
			$this->targetX->setDefaultValue($this->targetX->getValue());
			$this->targetY->setDefaultValue($this->targetY->getValue());
			$this->setSuccessMessage('Armee ist unterwegs');
		}
		
		$userUnits->save();
		
		// log outgoing armies
		$log = new DB_Record();
		foreach ($sendedUnits as $internalName => $sendedUnit)
			$log->$internalName = $sendedUnit;
		$log->user = $user;
		$log->opponent = $targetUser;
		$log->time = time();
		Rakuun_DB_Containers::getLogOutgoingArmiesContainer()->save($log);
		
		DB_Connection::get()->commit();
	}
	
	/**
	 * @return Rakuun_DB_User user if there has been a user specified / there is
	 * a user at the target coordinates
	 */
	public function getTargetUser() {
		$targetUser = $this->target->getUser();
		if (!$targetUser) {
			$options = array();
			$options['conditions'][] = array('city_x = ?', $this->targetX);
			$options['conditions'][] = array('city_Y = ?', $this->targetY);
			$targetUser = Rakuun_DB_Containers::getUserContainer()->selectFirst($options);
		}
		return $targetUser;
	}
	
	public function getArmy() {
		return $this->army;
	}
}

?>