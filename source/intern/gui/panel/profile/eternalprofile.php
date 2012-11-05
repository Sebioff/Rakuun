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

class Rakuun_Intern_GUI_Panel_Profile_EternalProfile extends GUI_Panel {
	const STATE_PREPARE = 0;
	const STATE_CONFIRM = 1;
	
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/eternalprofile.tpl');
		
		$options = array();
		$options['order'] = 'end_time DESC';
		$roundNames = array();
		foreach (Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->select($options) as $roundInformation)
			$roundNames[] = $roundInformation->roundName;
		
		$this->addPanel(new GUI_Control_DropDownBox('round', $roundNames, null, 'Runde'));
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('add', 'Hinzufügen'));
		$this->addPanel($state = new GUI_Control_HiddenBox('state'));
		
		$profiles = array();
		$eternalUser = Rakuun_DB_Containers::getUserEternalUserAssocContainer()->selectByUserFirst(Rakuun_User_Manager::getCurrentUser());
		if ($eternalUser) {
			$linkedProfiles = Rakuun_DB_Containers_Persistent::getEternalUserUserAssocContainer()->selectByEternalUser($eternalUser->eternalUser);
			foreach ($linkedProfiles as $profileAssoc) {
				$roundInformation = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByPK($profileAssoc->round);
				$adapter = Rakuun_Intern_Achievements_AdapterFactory::get()->getAdapterForRound($roundInformation->roundName);
				$profile = $adapter->getRoundContainer('user', $roundInformation->roundName)->selectByPK($profileAssoc->user);
				$profiles[] = 'Runde '.$roundInformation->roundName.': '.$profile->name;
			}
		}
		$this->params->linkedProfiles = $profiles;
	}
	
	public function onAdd() {
		$eternalUserAssoc = Rakuun_DB_Containers::getUserEternalUserAssocContainer()->selectByUserFirst(Rakuun_User_Manager::getCurrentUser());
		$eternalUser = Rakuun_DB_Containers_Persistent::getEternalUserContainer()->selectByPK($eternalUserAssoc->eternalUser);
		
		$adapter = Rakuun_Intern_Achievements_AdapterFactory::get()->getAdapterForRound($this->round->getValue());
		
		if ($adapter->isAlreadyConnected($this->username->getValue(), $this->round->getValue())) {
			if ($this->state->getValue() == self::STATE_PREPARE) {
				$this->state->setValue(self::STATE_CONFIRM);
				return;
			}
			else {
				if ($error = $adapter->changeUserEternalUserAssoc($this->username->getValue(), $this->password->getValue(), $this->round->getValue(), $eternalUser))
					$this->addError($error);
				else
					$this->state->setValue(self::STATE_PREPARE);
			}
		}
		else {
			if ($error = $adapter->addUserEternalUserAssoc($this->username->getValue(), $this->password->getValue(), $this->round->getValue(), $eternalUser))
				$this->addError($error);
			$this->state->setValue(self::STATE_PREPARE);
		}
		
		if ($this->hasErrors())
			return;
			
		$this->getModule()->invalidate();
	}
}

?>