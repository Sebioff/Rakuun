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

class Rakuun_Intern_GUI_Panel_Profile_EternalProfileConnect extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/eternalprofileconnect.tpl');
		
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('connect', 'Speichern'));
	}

	public function onConnect() {
		$eternalUser = Rakuun_DB_Containers_Persistent::getEternalUserContainer()->selectByNameFirst($this->username);
		
		if (!$eternalUser) {
			$this->addError('Falsche Zugangsdaten');
			return;
		}
			
		$checkPWUser = new Rakuun_DB_User();
		$checkPWUser->password = $eternalUser->password;
		$checkPWUser->salt = $eternalUser->salt;
		if (!Rakuun_User_Manager::checkPassword($checkPWUser, $this->password))
			$this->addError('Falsche Zugangsdaten');
		
		if ($this->hasErrors())
			return;
			
		$record = new DB_Record();
		$record->eternalUser = $eternalUser;
		$record->user = Rakuun_User_Manager::getCurrentUser();
		Rakuun_DB_Containers::getUserEternalUserAssocContainer()->save($record);
			
		$this->getModule()->invalidate();
	}
}

?>