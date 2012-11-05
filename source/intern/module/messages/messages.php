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

class Rakuun_Intern_Module_Messages extends Rakuun_Intern_Module {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->addSubmodule(new Rakuun_Intern_Module_Messages_Display('display'));
	}
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Nachrichten');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/messages.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('directory', new Rakuun_Intern_GUI_Panel_User_Directory('directory', Rakuun_Intern_GUI_Panel_User_Directory::TYPE_MESSAGES), 'Adressbuch'));
		if (!($messageType = $this->getParam('category')))
			$messageType = Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_UNREAD;
		if ($messageType == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS)
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('send', new Rakuun_Intern_GUI_Panel_Message_Support('support'), 'Support anschreiben'));
		else {
			$replyTo = array();
			$param = $this->getParam('user');
			if ($user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param))
				$replyTo[] = $user;
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('send', new Rakuun_Intern_GUI_Panel_Message_Send('send', '', null, $replyTo), 'Nachricht schicken'));
		}
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message_View('view', $messageType));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message_Categories('categories', 'Nachrichtenkategorien'));
	}
}

?>