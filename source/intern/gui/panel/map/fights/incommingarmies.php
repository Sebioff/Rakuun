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

class Rakuun_Intern_GUI_Panel_Map_Fights_IncommingArmies extends GUI_Panel {
	private $armiesPanels = array();
	
	public function init() {
		parent::init();
		
		$options = self::getOptionsForVisibleArmies();
		$options['order'] = 'target_time ASC';
		foreach (Rakuun_DB_Containers::getArmiesContainer()->select($options) as $army) {
			$this->addPanel($countdownPanel = new Rakuun_GUI_Panel_CountDown('cd_'.$army->getPK(), $army->targetTime));
			$countdownPanel->enableHoverInfo(true);
			$countdownPanel->setFinishedMessage('Kürze...');
			$this->armiesPanels[] = array(
				'countdownPanel' => $countdownPanel,
				'army' => $army
			);
		}
		
		$this->setTemplate(dirname(__FILE__).'/incommingarmies.tpl');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getArmiesPanels() {
		return $this->armiesPanels;
	}
	
	public static function getOptionsForVisibleArmies() {
		$options = array();
		$options['conditions'][] = array('target = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('target_x = ?', Rakuun_User_Manager::getCurrentUser()->cityX);
		$options['conditions'][] = array('target_y = ?', Rakuun_User_Manager::getCurrentUser()->cityY);
		$cloakingUnits = array();
		$unCloakingUnits = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if (!$unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY)) {
				if ($unit->getAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_CLOAKING)) {
					$cloakingUnits[] = $unit->getInternalName();
				}
				else {
					$unCloakingUnits[] = $unit->getInternalName();
				}
			}
		}
		$sensorfieldRange = Rakuun_Intern_Production_Factory::getBuilding('sensor_bay')->getRange();
		// respect cloaked armies + sensorfield
		$options['conditions'][] = array(implode('+', $cloakingUnits).' <= 0 OR ('.$sensorfieldRange.' > 0 && (target_time - '.$sensorfieldRange.' <= ? || target_time < ?)) OR '.implode('+', $unCloakingUnits).' > 0', time(), time());
		
		return $options;
	}
}

?>