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

class Rakuun_Intern_GUI_Panel_Admin_User_Edit extends GUI_Panel {

	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/edit.tpl');
		
		if (!$this->user)
			return;
		
		$this->addPanel($username = new GUI_Control_TextBox('username', $this->user->nameUncolored, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($cityname = new GUI_Control_TextBox('cityname', $this->user->cityName, 'Stadtname'));
		$cityname->addValidator(new GUI_Validator_Mandatory());
		$cityname->addValidator(new GUI_Validator_MaxLength(20));
		$this->addPanel($adminnews = new GUI_Control_Textarea('adminnews', $this->user->adminnews, 'Adminnews'));
		
		// FIXME create a privilege for this
		if (Rakuun_GameSecurity::get()->isInGroup($this->user, Rakuun_GameSecurity::GROUP_SPONSORS)) {
			$this->addPanel($description = new GUI_Control_Textarea('description', $this->user->description, 'Beschreibung'));
			$description->addValidator(new GUI_Validator_HTML());
			$description->addValidator(new GUI_Validator_MaxLength(5000));
		}

		$this->addPanel($skinselect = new GUI_Control_DropDownBox('skin', Rakuun_GUI_Skinmanager::get()->getAllSkins(), Rakuun_GUI_Skinmanager::get()->getCurrentSkin()->getNameID(), 'Skin'));
		$this->addPanel($mail = new GUI_Control_TextBox('mail', $this->user->mail, 'EMail-Adresse'));
		$mail->addValidator(new GUI_Validator_Mandatory());
		$mail->addValidator(new GUI_Validator_Mail());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
		
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		if ($this->user->nameUncolored != $this->username->getValue()) {
			$this->user->name = $this->username;
			$this->user->nameColored = '';
			
			$mail = new Net_Mail();
			$mail->setSubject('Rakuun: Nickname geändert');
			$mail->addRecipients($this->user->nameUncolored.' <'.$this->mail->getValue().'>');
			$templateEngine = new GUI_TemplateEngine();
			$templateEngine->username = $this->user->nameUncolored;
			$mail->setMessage($templateEngine->render(dirname(__FILE__).'/edit_nick_mail.tpl'));
			$mail->send();
		}
		$this->user->cityName = $this->cityname;
		$this->user->adminnews = $this->adminnews;
		if ($this->hasPanel('description'))
			$this->user->description = $this->description;
		$this->user->mail = $this->mail;
		$this->user->skin = $this->skin->getKey();
		Rakuun_User_Manager::update($this->user);
		Rakuun_GUI_Skinmanager::get()->setCurrentSkin($this->user->skin);
	}
	
	public function getUser() {
		return $this->user;
	}
}

?>