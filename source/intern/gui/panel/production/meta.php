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

/**
 * A panel displaying costs of a building and allowing to build/remove levels of
 * it.
 */
class Rakuun_Intern_GUI_Panel_Production_Meta extends Rakuun_Intern_GUI_Panel_Production_Production {
	const WIP_ITEM_MAXAMOUNT = 1; // maximum allowed amount of items in the wip list
	
	public function init() {
		parent::init();
		
		$this->produce->setValue('Auf Stufe '.$this->getProductionItem()->getNextBuildableLevel().' ausbauen');
		if ($this->hasPanel('remove'))
			$this->removePanel($this->remove);
		
		$options = array();
		$options['conditions'][] = array('meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
		if (Rakuun_DB_Containers::getMetasBuildingsWIPContainer()->count($options) >= self::WIP_ITEM_MAXAMOUNT || !$this->getProductionItem()->canBuild()) {
			$this->removePanel($this->produce);
		}
		
		$requirements = $this->getProductionItem()->getNeededRequirements();
		$i = 0;
		if ($requirements) {
			$this->addHeadPanel(new GUI_Panel_Text('requirements', 'Voraussetzungen:<br/>'));
			foreach ($requirements as $requirement) {
				$this->addHeadPanel($requirementPanel = new GUI_Panel_Text('requirement'.$i, $requirement->getDescription().'<br/>'));
				if ($requirement->fulfilled())
					$requirementPanel->addClasses('rakuun_requirements_met');
				else
					$requirementPanel->addClasses('rakuun_requirements_failed');
				$i++;
			}
		}
		
		// FIXME kinda hacky
		if ($this->getProductionItem() instanceof Rakuun_Intern_Production_Building_Metas_Dancertia)
			$this->addHeadPanel(new Rakuun_Intern_GUI_Panel_Production_Meta_Defenders('defenders'));
	}
	
	public function onProduce() {
		parent::onProduce();
		
		if ($this->hasErrors()) {
			return;
		}
		
		DB_Connection::get()->beginTransaction();
		$nextBuildableLevel = $this->getProductionItem()->getNextBuildableLevel();
		$ironCosts = $this->getProductionItem()->getIronCostsForLevel($nextBuildableLevel);
		$berylliumCosts = $this->getProductionItem()->getBerylliumCostsForLevel($nextBuildableLevel);
		$energyCosts = $this->getProductionItem()->getEnergyCostsForLevel($nextBuildableLevel);
		$peopleCosts = $this->getProductionItem()->getPeopleCostsForLevel($nextBuildableLevel);
		$this->getProductionItem()->getOwner()->ressources->lower($ironCosts, $berylliumCosts, $energyCosts, $peopleCosts);
		$record = new DB_Record();
		$record->meta = $this->getProductionItem()->getOwner();
		$record->building = $this->getProductionItem()->getInternalName();
		$record->level = $nextBuildableLevel;
		$record->starttime = time();
		$record->position = time();
		Rakuun_DB_Containers::getMetasBuildingsWIPContainer()->save($record);
		DB_Connection::get()->commit();
		Router::get()->getCurrentModule()->invalidate();
	}
}

?>