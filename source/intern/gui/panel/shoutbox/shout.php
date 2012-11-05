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
 * Class to display a single shout.
 */
class Rakuun_Intern_GUI_Panel_Shoutbox_Shout extends GUI_Panel {
	private $config = null;
	private $shout = null;
	
	public function __construct($name, Shoutbox_Config $config, DB_Record $shout, $title = '') {
		$this->config = $config;
		$this->shout = $shout;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/shout.tpl');
		$this->params->shout = $this->shout;
		$this->addPanel(new GUI_Panel_Date('date', $this->shout->date));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('userlink', $this->shout->user, $this->shout->get('user')));
		if ($this->shout->user) {
			$params['answerid'] = $this->shout->user->getPK();
			$params[$this->getParent()->getName().'-page'] = $this->getParent()->getPage();
			$this->addPanel($answerLink = new GUI_Control_JsLink('answerlink', '-antworten-', '$(\'#'.$this->getParent()->shoutarea->getID().'\').val(\'@@'.$this->shout->user->nameUncolored.'@: \').focus(); return false;', Router::get()->getCurrentModule()->getUrl($params)));
			$answerLink->setAttribute('rel', 'nofollow');
			$answerLink->addClasses('answerlink');
		}
		if ($this->config->getUserIsMod() && $this->getModule()->getParam('moderate') == Rakuun_User_Manager::getCurrentUser()->getPK())
			$this->addPanel(new Rakuun_Intern_GUI_Panel_Shoutbox_Moderate('moderate', $this->config, $this->shout));
	}
}

?>