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

class Rakuun_Intern_Module_Meta extends Rakuun_Intern_Module_Meta_Common {
	public function __construct($name) {
		parent::__construct($name);
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addSubmodule(new Rakuun_Intern_Module_Meta_Polls('polls'));
		if ($user && Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)) {
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Applications('applications'));
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Edit('edit'));
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Build('build'));
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Interaction('interaction'));
		}
		if ($user && Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_STATISTICS))
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Statistics('statistics'));
	}
	
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/meta.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$meta = $user->alliance->meta;
		$this->setPageTitle('Meta - '.$meta->name);
		if ($meta->picture)
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('picturebox', new GUI_Panel_UploadedFile('metaepicture', $meta->picture, 'Metabild der Meta '.$meta->name), 'Metabild'));
		else
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('picturebox', new GUI_Panel_Text('dummy', 'Kein Bild vorhanden'), 'Metabild'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('internbox', $intern = new GUI_Panel_Text('intern', $meta->intern ? Rakuun_Text::formatPlayerText($meta->intern, false) : 'Keine Beschreibung'), 'Interne Informationen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('shoutboxbox', new Rakuun_Intern_GUI_Panel_Shoutbox_Meta('shouts', $meta), 'Shoutbox'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('boardbox', new Rakuun_Intern_GUI_Panel_Board_Overview_Meta('board'), 'Neues aus dem Metaforum'));
		
		$options = array();
		$options['order'] = 'date DESC';
		$options['conditions'][] = array('type = ?', Rakuun_Intern_GUI_Panel_Polls::POLL_META);
		$options['conditions'][] = array('meta = ?', $meta);
		$poll = Rakuun_DB_Containers::getPollsContainer()->selectFirst($options);
		if ($poll)
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('pollbox', new Rakuun_Intern_GUI_Panel_Polls_Poll('poll'.$poll->getPK(), $poll), 'Letzte Umfrage'));
	}
	
//	public function checkPrivileges() {
//		$user = Rakuun_User_Manager::getCurrentUser();
//		return (isset($user->alliance) && (isset($user->alliance->meta) || Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)));
//	}
}
?>