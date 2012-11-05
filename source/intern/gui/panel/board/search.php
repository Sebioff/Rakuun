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

class Rakuun_Intern_GUI_Panel_Board_Search extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config, $title = '') {
		parent::__construct($name, $title);
		
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($text = new GUI_Control_TextBox('board', '', 'Boardname'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('search', 'suchen'));
	}
	
	public function onSearch() {
		$options = array();
		$options['conditions'][] = array('`name` LIKE ?', '%'.str_replace('*', '%', $this->board->getValue()).'%');
		$options['order'] = 'name ASC, date DESC';
		$boards = $this->config->getBoardsContainer()->select($options);
		if (!empty($boards)) {
			$list = new GUI_Panel_List('result');
			$module = $this->getModule();
			foreach ($boards as $board) {
				$list->addItem(new GUI_Control_Link('board'.$board->getPK(), $board->name, $module->getUrl(array('board' => $board->getPK()))));
			}
			$this->addPanel($list);
		}
	}
}
?>