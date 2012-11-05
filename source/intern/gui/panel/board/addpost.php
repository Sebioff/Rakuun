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
 * Displays form for adding a post
 */
class Rakuun_Intern_GUI_Panel_Board_AddPost extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config) {
		parent::__construct($name);
		
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/addpost.tpl');
		
		$this->addPanel($text = new GUI_Control_TextArea('text', null, 'Posting'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'posten'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$posting = $this->config->getPostingRecord();
		$posting->board = $this->config->getBoardRecord();
		$posting->text = $this->text;
		$posting->date = time();
		$this->config->getPostingsContainer()->save($posting);
		$this->config->getBoardRecord()->date = time();
		$this->config->getBoardRecord()->save();
		DB_Connection::get()->commit();
		$this->text->resetValue();
		$this->getModule()->invalidate();
	}
}
?>