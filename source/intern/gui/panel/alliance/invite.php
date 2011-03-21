<?php

/**
 * Panel to send an invitation to users without an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Invite extends GUI_Panel {
	const MAX_INVITATIONS_PER_DAY = 3;
	
	public function init() {
		parent::init();
		
		if (Rakuun_User_Manager::getCurrentUser()->alliance->invitations >= self::MAX_INVITATIONS_PER_DAY) {
			$this->addError('Heute wurden schon '.self::MAX_INVITATIONS_PER_DAY.' Einladungen verschickt!');
		}
		else {
			$this->addPanel(new GUI_Panel_Text('counter', 'Heute können noch '.(self::MAX_INVITATIONS_PER_DAY - Rakuun_User_Manager::getCurrentUser()->alliance->invitations).' Einladungen verschickt werden.'));
		}
		
		$this->setTemplate(dirname(__FILE__).'/invite.tpl');
		$options = $this->getPossibleRecipientOptions();
		$options['order'] = 'name ASC';
		$users = Rakuun_DB_Containers::getUserContainer()->select($options);
		$_users = array();
		foreach ($users as $user) {
			if (!Rakuun_GameSecurity::get()->isInGroup($user, Rakuun_GameSecurity::GROUP_LOCKED))
				$_users[$user->getPK()] = $user->nameUncolored;
		}
		if (empty($_users)) {
			$this->addError('no users without an alliance found');
			return;
		}
		$this->addPanel(new GUI_Control_DropDownBox('users', $_users, null, 'Adressat'));
		$this->addPanel($text = new GUI_Control_TextArea('text', '[Allianz beitreten]', 'Nachricht'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$text->addValidator($html = new GUI_Validator_HTML());
		$html->setWhitelistElements('a', 'b', 'center', 'hr', 'i', 's', 'strike', 'strong', 'sub', 'sup', 'u');
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Abschicken'));
		$this->addPanel(new GUI_Panel_Text('info', '[Allianz beitreten] wird nach dem Abschicken durch einen Link ersetzt, über den der Empfänger direkt in die Allianz eintreten kann!', 'Information'));
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		if (Rakuun_GameSecurity::get()->isInGroup($user, Rakuun_GameSecurity::GROUP_DEMO))
			$this->addError('Demo-User darf keine Einladungen verschicken.');
		
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$options = $this->getPossibleRecipientOptions();
		$options['conditions'][] = array('id = ?', $this->users->getKey());
		$recipient = Rakuun_DB_Containers::getUserContainer()->selectFirst($options);
		if (!$recipient || Rakuun_GameSecurity::get()->isInGroup($recipient, Rakuun_GameSecurity::GROUP_LOCKED)) {
			$this->addError('No User found');
			return;
		}
		$igm = new Rakuun_Intern_IGM(
			'Allianzeinladung ['.$user->alliance->tag.'] '.$user->alliance->name,
			$recipient,
			'temp',
			Rakuun_Intern_IGM::TYPE_ALLIANCE
		);
		$igm->setSender($user);
		//send IGM with dummytext to create the igm's private key
		$igm->send();
		//create link with hash and igm's private key
		$url = App::get()->getInternModule()->getSubmodule('alliance')->getURL(
			array(
				'id' => $user->alliance->getPK(),
				'msgid' => $igm->getPK(),
				'do' => md5(
					'invite' .
					$recipient->nameUncolored .
					$user->alliance->getPK() .
					$igm->getPK()
				)
			)
		);
		$link = new GUI_Control_Link('alliancelink', 'Allianz beitreten', $url);
		$igm->setText(str_replace('[Allianz beitreten]', $link->render(), $this->text->getValue()));
		//finally save IGM with updated text
		$igm->save();
		
		$attachmentRecord = new DB_Record();
		$attachmentRecord->message = $igm;
		$attachmentRecord->type = Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION;
		$attachmentRecord->value = $igm;
		Rakuun_DB_Containers::getMessagesAttachmentsContainer()->save($attachmentRecord);
		
		$this->setSuccessMessage('Nachricht verschickt');
		//increment invitationscounter
		$alliance = $user->alliance;
		$alliance->invitations++;
		$alliance->save();
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
	
	/**
	 * @return array of options
	 */
	private function getPossibleRecipientOptions() {
		$options = array();
		$options['conditions'][] = array('alliance is NULL');
		$options['conditions'][] = array('is_yimtay = ?', false);
		return $options;
	}
}

?>
