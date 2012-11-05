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
 * Panel to search the list of alliances.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Search extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Name / Tag'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Suchen'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		$searchFor = '%'.str_replace('*', '%', $this->name).'%';
		$alliances = Rakuun_DB_Containers::getAlliancesContainer()->select(array('conditions' => array(array('name LIKE ? OR tag LIKE ?', $searchFor, $searchFor))));
		$this->params->alliances = $alliances;
	}
}

?>