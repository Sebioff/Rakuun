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

class Rakuun_Intern_GUI_Panel_Reports_Filter extends GUI_Panel {
	const WHO_ATTER = 'user';
	const WHO_DEFFER = 'spied_user';
	const HOW_EQUAL = 'equal';
	const HOW_UNEQUAL = 'unequal';
	const HOW_GT_EQUAL = 'gt-equal';
	const HOW_LT_EQUAL = 'lt-equal';
	const FILTER_COUNT = 2;
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/filter.tpl');
		$this->addPanel($filterControl = new GUI_Control_DropDownBox('filter', array(self::WHO_ATTER => 'Angreifer', self::WHO_DEFFER => 'Ziel')));
		$filterControl->addClasses('filter');
		$this->addPanel(new GUI_Control_DropDownBox('how', array(self::HOW_EQUAL => '==', self::HOW_UNEQUAL => '!=')));
		$this->addPanel(new Rakuun_GUI_Control_UserSelect('what'));
		$filter = array();
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		foreach ($units as $unit) {
			$filter[$unit->getInternalName()] = $unit->getName();
		}
		$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
		foreach ($buildings as $building) {
			$filter[$building->getInternalName()] = $building->getName();
		}
		for ($i = 0; $i < self::FILTER_COUNT; $i++) {
			$this->addPanel($filterControl = new GUI_Control_DropDownBox('filter'.$i, $filter));
			$filterControl->addClasses('filter');
			$this->addPanel(new GUI_Control_DropDownBox('how'.$i, array(self::HOW_LT_EQUAL => '<=', self::HOW_EQUAL => '==', self::HOW_GT_EQUAL => '>=', self::HOW_UNEQUAL => '!=')));
			$this->addPanel(new GUI_Control_TextBox('what'.$i));
		}
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Filtern'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$this->getModule()->contentPanel->reportsbox->getContentPanel()->reports->addFilter(
			array(
				'filter' => $this->filter->getKey(),
				'how' => $this->how->getKey(),
				'what' => $this->what->getUser()
			)
		);
		for ($i = 0; $i < self::FILTER_COUNT; $i++) {
			$this->getModule()->contentPanel->reportsbox->getContentPanel()->reports->addFilter(
				array(
					'filter' => $this->{'filter'.$i}->getKey(),
					'how' => $this->{'how'.$i}->getKey(),
					'what' => $this->{'what'.$i}->getValue()
				)
			);
		}
	}
	
	public static function getRelation($relation) {
		$relations = array(
			self::HOW_EQUAL => '=',
			self::HOW_UNEQUAL => '!=',
			self::HOW_GT_EQUAL => '>=',
			self::HOW_LT_EQUAL => '<='
		);
		return $relations[$relation];
	}
}
?>