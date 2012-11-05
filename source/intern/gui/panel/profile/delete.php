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
 * Panel which displays a Button to delete own account.
 */
class Rakuun_Intern_GUI_Panel_Profile_Delete extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/delete.tpl');
		
		$this->addPanel($deleteButton = new GUI_Control_SecureSubmitButton('submit', 'Löschen'));
		$deleteButton->setConfirmationMessage('Soll der Account wirklich gelöscht werden?');
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_TextArea('text', null, 'Begründung'));
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		
		if (!Rakuun_User_Manager::checkPassword($user, $this->password->getValue()))
			$this->addError('Das Passwort ist nicht korrekt');
			
		if ($user->getDatabaseCount() > 0)
			$this->addError('Du kannst dich mit einem Datenbankteil wirklich nicht löschen!');
		
		if ($user->alliance && count(Rakuun_Intern_Alliance_Security::get()->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS)) == 1 && Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS))
			$this->addError('Du bist der einzige in der Leiter-Gruppe deiner Allianz. Bitte gib die Leitung an einen anderen Spieler ab, bevor du dich löscht.');
		
		if ($this->hasErrors())
			return;
			
		if ($this->text->getValue()) {
			// TODO ewww, IGM to hardcoded player. Save deletion reasons somewhere else.
			$igm = new Rakuun_Intern_IGM('Spielerlöschung', Rakuun_DB_Containers::getUserContainer()->selectByNameFirst('Sebioff'));
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
			$igm->setText($user->name.' hat sich mit folgender Begründung gelöscht:<br/>'.nl2br(Text::escapeHTML($this->text->getValue())));
			$igm->send();
		}
			
		DB_Connection::get()->beginTransaction();
		Rakuun_User_Manager::logout();
		Rakuun_Intern_Log_UserActivity::log($user, Rakuun_Intern_Log::ACTION_ACTIVITY_DELETE);
		Rakuun_User_Manager::delete($user, $this->text->getValue());
		DB_Connection::get()->commit();
		Scriptlet::redirect(App::get()->getIndexModule()->getURL());
	}
}

?>