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

class Rakuun_Intern_Module_Alliance_Profile_Own extends Rakuun_Intern_Module {
	const FOUNDINGCOSTS_IRON = 100;
	const FOUNDINGCOSTS_BERYLLIUM = 100;
	
	public function __construct($name) {
		parent::__construct($name);
		
		// TODO totally stupid, has to be done in a different way, because:
		// for every single page load EVERY constructor of EVERY module is called,
		// thus the privileges for that submodule is checked on EVERY pageload
		// (even for not logged-in users!)
		
		if (Rakuun_User_Manager::getCurrentUser()) {
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Applications('applications'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Edit('edit'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Diplomacy('diplomacy'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Statistics('statistics'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Polls('polls'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Account('account'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Build('build'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Interact('interact'));
		}
	}
	
	public function init() {
		parent::init();
		
		// display overview page
		$this->contentPanel->setTemplate(dirname(__FILE__).'/own.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->setPageTitle('Allianz - ['.$user->alliance->tag.'] '.$user->alliance->name);
		
		if ($user->alliance->picture)
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('picturebox', new GUI_Panel_UploadedFile('alliancepicture', $user->alliance->picture, 'Allianzbild der Allianz '.$user->alliance->name), 'Allianzbild'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('internbox', new Rakuun_Intern_GUI_Panel_Alliance_Internbox('internbox', 'Interne Informationen')));
		$this->contentPanel->addPanel($shoutbox = new Rakuun_GUI_Panel_Box('shoutboxbox', new Rakuun_Intern_GUI_Panel_Shoutbox_Alliance('shoutbox'), 'Allianzshoutbox'));
		$shoutbox->addClasses('rakuun_box_alliance_shoutbox');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('boardbox', new Rakuun_Intern_GUI_Panel_Board_Overview_Alliance('board'), 'Neues aus dem Allianzforum'));
		$options = array();
		$options['order'] = 'date DESC';
		$options['conditions'][] = array('type = ?', Rakuun_Intern_GUI_Panel_Polls::POLL_ALLIANCE);
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$poll = Rakuun_DB_Containers::getPollsContainer()->selectFirst($options);
		if ($poll)
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('pollbox', new Rakuun_Intern_GUI_Panel_Polls_Poll('poll'.$poll->getPK(), $poll), 'Letzte Umfrage'));
	}
}
?>