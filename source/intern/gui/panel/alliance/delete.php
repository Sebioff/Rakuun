<?php

/**
 * Panel which displays a Button to delete an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Delete extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/delete.tpl');
		
		$this->addPanel(new GUI_Control_SecureSubmitButton('submit', 'Löschen'));
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		if (!Rakuun_User_Manager::checkPassword($user, $this->password->getValue()))
			$this->addError('Das Passwort ist nicht korrekt');
		
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$userLink = new Rakuun_GUI_Control_UserLink('userlink', $user);
		foreach ($user->alliance->members as $member) {
			if ($member->getPK() == $user->getPK())
				continue;
			
			$igm = new Rakuun_Intern_IGM('Deine Allianz wurde aufgelöst', $member);
			$igm->setText('Deine Allianz wurde gerade von '.$userLink->render().' aufgelöst.');
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
			$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
			$igm->send();
		}
		Rakuun_DB_Containers::getAlliancesContainer()->delete($user->alliance);
		$user->alliance = null;
		Rakuun_User_Manager::update($user);
		DB_Connection::get()->commit();
		$this->getModule()->redirect(App::get()->getInternModule()->getSubmodule('alliance')->getURL());
	}
}

?>