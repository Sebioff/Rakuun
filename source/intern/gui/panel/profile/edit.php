<?php

class Rakuun_Intern_GUI_Panel_Profile_Edit extends Rakuun_GUI_Panel_Box {
	public function __construct($name) {
		parent::__construct($name);
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->contentPanel->setTemplate(dirname(__FILE__).'/edit.tpl');
		if (Rakuun_GameSecurity::get()->hasPrivilege($user, Rakuun_GameSecurity::PRIVILEGE_COLOREDNAME)) {
			$this->contentPanel->addPanel($nameColored = new Rakuun_Intern_GUI_Control_ColoredName('namecolored', $user, 'Nickname (farbig)'));
			$nameColored->addValidator(new GUI_Validator_MaxLength(255));
			$this->contentPanel->addPanel(
				new GUI_Panel_HoverInfo(
					'namecoloredhelp',
					'[help]',
					'[darkblue]'.$user->nameUncolored.'[/darkblue]<br />' .
					'[lime]'.$user->nameUncolored.'[/lime]<br />' .
					'[limeblue]'.$user->nameUncolored.'[/limeblue]<br />' .
					'[purple]'.$user->nameUncolored.'[/purple]<br />' .
					'[pink]'.$user->nameUncolored.'[/pink]<br />' .
					'[brown]'.$user->nameUncolored.'[/brown]<br />' .
					'[gold]'.$user->nameUncolored.'[/gold]<br />' .
					'[orange]'.$user->nameUncolored.'[/orange]<br />' .
					'[lightgrey]'.$user->nameUncolored.'[/lightgrey]<br />' .
					'[darkgrey]'.$user->nameUncolored.'[/darkgrey]<br />' .
					'[white]'.$user->nameUncolored.'[/white]<br />' .
					'[#2288EE]'.$user->nameUncolored.'[/#2288EE]<br />'
				)
			);
		}
		$this->contentPanel->addPanel($cityname = new GUI_Control_TextBox('cityname', $user->cityName, 'Stadtname'));
		$cityname->addValidator(new GUI_Validator_Mandatory());
		$cityname->addValidator(new GUI_Validator_MaxLength(20));
		
		$this->contentPanel->addPanel($icq = new GUI_Control_DigitBox('icq', $user->icq, 'ICQ'));
		$icq->addValidator(new GUI_Validator_MaxLength(9));
		
		if (Rakuun_GameSecurity::get()->isInGroup($user, Rakuun_GameSecurity::GROUP_SPONSORS)) {
			$this->contentPanel->addPanel($description = new GUI_Control_Textarea('description', $user->description, 'Beschreibung'));
			$description->addValidator(new GUI_Validator_HTML());
			$description->addValidator(new GUI_Validator_MaxLength(5000));
		}
		
		$this->contentPanel->addPanel($skinselect = new GUI_Control_DropDownBox('skin', Rakuun_GUI_Skinmanager::get()->getAllSkins(), Rakuun_GUI_Skinmanager::get()->getCurrentSkin()->getNameID(), 'Skin'));
		$this->contentPanel->addPanel($mail = new GUI_Control_TextBox('mail', $user->mail, 'EMail-Adresse'));
		$mail->addValidator(new GUI_Validator_Mandatory());
		$mail->addValidator(new GUI_Validator_Mail());
		
		$this->contentPanel->addPanel($sitter = new Rakuun_GUI_Control_UserSelect('sitter', null, 'Sitter'));
		if ($user->sitter)
			$sitter->setValue($user->sitter->nameUncolored);
		
		$this->contentPanel->addPanel($picture = new GUI_Control_FileUpload('picture', 102400, 'Profilbild'));
		$picture->setAllowedFiletypes(array(GUI_Control_FileUpload::TYPE_GIF, GUI_Control_FileUpload::TYPE_JPEG, GUI_Control_FileUpload::TYPE_PNG));
		$this->contentPanel->addPanel(new GUI_Control_CheckBox('tutorial', 1, (bool)$user->tutorial, 'Zeige Tutorial'));
		$this->contentPanel->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		Router::get()->getCurrentModule()->addJsAfterContent(sprintf('var currentSkin = $("#%1$s").val(); $("#%1$s").change(function(){$("body").removeClass("skin_"+currentSkin).addClass("skin_"+$(this).val()); currentSkin = $(this).val();});', $this->contentPanel->skin->getID()));
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$sitter = $this->contentPanel->sitter->getUser();
		
		if ($sitter) {
			if ($sitter->getPK() == $user->getPK())
				$this->contentPanel->addError('Du kannst dich nicht selbst sitten.', $this->contentPanel->sitter);
				
			if ((!$user->sitter || $user->sitter->getPK() != $sitter->getPK()) && Rakuun_DB_Containers::getUserContainer()->countBySitter($sitter) > 0)
				$this->contentPanel->addError('Dieser Spieler sittet bereits jemanden.', $this->contentPanel->sitter);
		}
		
		if ($this->contentPanel->hasErrors())
			return;
		
		if ($this->contentPanel->hasPanel('namecolored'))
			$user->nameColored = $this->contentPanel->namecolored;
		$user->cityName = trim($this->contentPanel->cityname);
		$user->icq = $this->contentPanel->icq;
		
		if ($this->contentPanel->hasPanel('description'))
			$user->description = $this->contentPanel->description;
			
		if ($this->contentPanel->mail != $user->mail)
			Rakuun_Intern_Log_Userdata::log($user, Rakuun_Intern_Log::ACTION_USERDATA_EMAIL, $this->contentPanel->mail);
		$user->mail = $this->contentPanel->mail;
		$user->skin = $this->contentPanel->skin->getKey();
		
		$picture = $this->contentPanel->picture->moveTo('user_'.$user->nameUncolored);
		if ($picture) {
			if ($user->picture) {
				// remove old picture
				$file = new IO_File($user->picture);
				if (!$file->delete())
					$this->addError('Couldn\'t delete old user image');
			}
			$image = new IO_Image($picture['path'].DIRECTORY_SEPARATOR.$picture['new_name']);
			$image->resize(300, 200);
			$image->save();
			
			$user->picture = $picture['path'].DIRECTORY_SEPARATOR.$picture['new_name'];
		}
		
		if ($sitter && (!$user->sitter || $user->sitter->getPK() != $sitter->getPK())) {
			$igm = new Rakuun_Intern_IGM('Als Sitter eingetragen', $sitter);
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
			$igm->setText('Du wurdest von '.$user->name.' als Sitter eingetragen.');
			$igm->send();
			Rakuun_Intern_Log_Userdata::log($user, Rakuun_Intern_Log::ACTION_USERDATA_SITTER, $sitter->name);
		} else if ($user->sitter && !$sitter)
			Rakuun_Intern_Log_Userdata::log($user, Rakuun_Intern_Log::ACTION_USERDATA_SITTER, 'kein Sitter');
		$user->sitter = $sitter;
		$user->tutorial = $this->contentPanel->tutorial->getSelected();
		
		Rakuun_User_Manager::update($user);
		Rakuun_GUI_Skinmanager::get()->setCurrentSkin($user->skin);
		$this->getModule()->invalidate();
	}
}

?>