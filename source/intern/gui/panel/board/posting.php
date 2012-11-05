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
 * Displays a specific posting.
 */
class Rakuun_Intern_GUI_Panel_Board_Posting extends GUI_Panel {
	private $posting = null;
	private $config = null;
	
	public function __construct($name, DB_Record $posting, Board_Config $config) {
		parent::__construct($name);
		
		$this->posting = $posting;
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		 
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->setTemplate(dirname(__FILE__).'/posting.tpl');
		if ((Router::get()->getCurrentModule()->getParam('edit') == $this->posting->getPK()
			&& $this->posting->deleted == 0)
			&& (($this->posting->user && $this->posting->user->getPK() == $user->getPK())
				|| ($this->posting->userName && $this->posting->userName == $user->nameUncolored && $this->posting->roundNumber == RAKUUN_ROUND_NAME))
		) {
			$this->addPanel($blanko = new GUI_Panel('form'));
			$blanko->addPanel($text = new GUI_Control_TextArea('text', $this->posting->text, 'Posting'));
			$text->addValidator(new GUI_Validator_Mandatory());
			$blanko->addPanel(new GUI_Control_SubmitButton('edit', 'speichern'));
		}
		$this->params->posting = $this->posting;
		$this->params->config = $this->config;
		
		$this->addPanel(new GUI_Panel_Date('date', $this->posting->date));
		if ($this->config->getIsGlobal()) {
			// posting is from global board
			if ($this->posting->roundNumber == RAKUUN_ROUND_NAME) {
				// user belongs to actual rakuun-round
				$postingUser = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->posting->userName);
				$this->addPanel(new Rakuun_GUI_Control_UserLink('user', $postingUser));
			} else {
				// user belongs to historic rakuun-round
				$this->addPanel(new GUI_Panel_Text('user', $this->posting->userName.' ['.$this->posting->roundNumber.']'));
			}
		} else {
			$this->addPanel(new Rakuun_GUI_Control_Userlink('user', $this->posting->user, $this->posting->get('user')));
		}
		if ($this->posting->editdate)
			$this->addPanel(new GUI_Panel_Date('editdate', $this->posting->editdate));
		if ($this->posting->deleted == 0
			&& (($this->posting->user && $this->posting->user->getPK() == $user->getPK())
			|| ($this->posting->userName && $this->posting->userName == $user->nameUncolored && $this->posting->roundNumber == RAKUUN_ROUND_NAME)))
		{
			$urlParams = $this->getModule()->getParams();
			$urlParams['edit'] = $this->posting->getPK();
			$this->addPanel(new GUI_Control_Link('editlink', '-edit-', Router::get()->getCurrentModule()->getUrl($urlParams)));
		}
		if ($this->getModule()->getParam('moderate') == $user->getPK()) {
			$this->addPanel($deleteButton = new GUI_Control_SubmitButton('delete', 'Löschen'));
			$deleteButton->setConfirmationMessage('Das Posting von '.date(GUI_Panel_Date::FORMAT_DATETIME, $this->posting->date).' wirklich löschen?');
		}
	}
	
	public function onEdit() {
		if ($this->hasErrors())
			return;
		
		$this->posting->text = $this->form->text->getValue();
		$this->posting->editdate = time();
		$this->posting->save();
		$this->getModule()->redirect($this->getModule()->getUrl(array('board' => $this->posting->board)));
	}
	
	public function onDelete() {
		if ($this->hasErrors())
			return;
		
		$this->posting->deleted = 1;
		if ($this->config->getIsGlobal()) {
			$this->posting->deletedByName = Rakuun_User_Manager::getCurrentUser()->nameUncolored;
			$this->posting->deletedByRoundNumber = RAKUUN_ROUND_NAME;
		} else {
			$this->posting->deletedBy = Rakuun_User_Manager::getCurrentUser();
		}
		$this->posting->save();
		$this->getModule()->redirect($this->getModule()->getUrl(array('board' => $this->posting->board)));
	}
	
	public function checkDisplayPosting() {
		if ($this->config->getIsGlobal()) {
			if (($this->params->posting->deleted == 1 && (($this->params->posting->userName == Rakuun_User_Manager::getCurrentUser()->nameUncolored && $this->params->posting->roundNumber == RAKUUN_ROUND_NAME) || $this->params->config->getUserIsMod()))
			|| $this->params->posting->deleted == 0)
				return true;
		} else {
			if (($this->params->posting->deleted == 1 && ($this->params->posting->user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK() || $this->params->config->getUserIsMod()))
			|| $this->params->posting->deleted == 0)
				return true;
		}
		return false;
	}
}

?>