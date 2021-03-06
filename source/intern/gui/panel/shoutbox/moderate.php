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

class Rakuun_Intern_GUI_Panel_Shoutbox_Moderate extends GUI_Panel {
	const TIMEBAN_LENGTH = 10800; //3h
	
	protected $config = null;
	protected $shout = null;
	
	public function __construct($name, Shoutbox_Config $config, DB_Record $shout, $title = '') {
		$this->config = $config;
		$this->shout = $shout;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/moderate.tpl');
		
		$module = $this->getModule();
		$this->addPanel($deleteLink = new GUI_Control_Link('delete', '-Löschen-', $module->getUrl(array('moderate' => Rakuun_User_Manager::getCurrentUser()->getPK(), 'delete' => $this->shout->getPK()))));
		$deleteLink->setConfirmationMessage('Diesen Post wirklich löschen?');
		if ($this->config->getIsGlobal()) {
			$this->addPanel($timebanLink = new GUI_Control_Link('timeban', '-Timeban-', $module->getUrl(array('moderate' => Rakuun_User_Manager::getCurrentUser()->getPK(), 'timeban' => $this->shout->getPK(), 'time' => self::TIMEBAN_LENGTH))));
			$timebanLink->setConfirmationMessage('Diesen User wirklich für '.Rakuun_Date::formatCountDown(self::TIMEBAN_LENGTH).' bannen?');
		}
		
		if ($module->getParam('moderate') == Rakuun_User_Manager::getCurrentUser()->getPK()) {
			// delete post
			if ($module->getParam('delete') == $this->shout->getPK()) {
				$this->shout->delete();
				$this->getModule()->invalidate();
			}
				
			// timeban user
			if ($this->config->getIsGlobal() && $module->getParam('timeban') == $this->shout->getPK()) {
				$this->shout->user->shoutboxTimeban = time() + $module->getParam('time');
				$this->shout->user->save();
				$igm = new Rakuun_Intern_IGM('Shoutbox Ban', $this->shout->user);
				$igm->setText('
					Hallo '.$this->shout->user->nameUncolored.',
					Du wurdest gerade von '.Rakuun_User_Manager::getCurrentUser()->nameUncolored.' für '.Rakuun_Date::formatCountDown($module->getParam('time')).'
					aus der Shoutbox gebannt.
				');
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
				$igm->send();
			}
		}
	}
}
?>