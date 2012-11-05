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

class Rakuun_Intern_GUI_Panel_Board_AddBoard extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config, $title = '') {
		$this->config = $config;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();

		$this->setTemplate(dirname(__FILE__).'/addboard.tpl');
		
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Boardname'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new GUI_Validator_RangeLength(2, 25));
		$this->addPanel(new GUI_Control_SubmitButton('addboard', 'anlegen'));
	}
	
	public function onAddBoard() {
		if ($this->hasErrors())
			return;
		
		$board = $this->config->getBoardRecord();
		$board->name = Text::escapeHTML($this->name->getValue());
		$board->date = time();
		$this->config->getBoardsContainer()->save($board);
		$this->name->resetValue();
		$this->getModule()->invalidate();
	}
}
?>