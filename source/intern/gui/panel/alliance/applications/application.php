<?php

/**
 * Panel to write an application for an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Applications_Application extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		if (!$this->getModule()->getParam('alliance')) {
			$this->addError('Seitenaufruf ohne Allianz Parameter.');
			return;
		}
		$this->setTemplate(dirname(__FILE__).'/application.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($user->alliance)
			$this->addError('Du hast bereits eine Allianz.');
		$this->addPanel($text = new GUI_Control_TextArea('text'));
		$text->setTitle('Bewerbungstext');
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Bewerben'));
	}
	
	public function onSubmit() {
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('status = ?', Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_NEW);
		$options['conditions'][] = array('alliance = ?', $this->getModule()->getParam('alliance'));
		$count = Rakuun_DB_Containers::getAlliancesApplicationsContainer()->count($options);
		if ($count > 0) 
			$this->addError('Es liegt noch eine nicht bearbeitete Bewerbung von dir bei dieser Allianz vor!');
		
		if (Rakuun_User_Manager::isSitting())
			$this->addError('Als Sitter kannst du dich nicht bei einer Allianz bewerben.');
		
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		//Save the application
		$application = new DB_Record();
		$application->user = Rakuun_User_Manager::getCurrentUser();
		$application->alliance = $this->getModule()->getParam('alliance');
		$application->text = $this->text;
		$application->date = time();
		$application->status = Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_NEW;
		Rakuun_DB_Containers::getAlliancesApplicationsContainer()->save($application);
		//Send an igm to all privileged Members of the alliance	
		$userlink = new Rakuun_GUI_Control_UserLink('userlink', Rakuun_User_Manager::getCurrentUser());
		Rakuun_Intern_Alliance_Security::push(Security_AllPrivileges::get());
		$allianceModuleLink = new GUI_Control_Link('allianceslink', 'Allianzen', App::get()->getInternModule()->getSubmodule('alliance')->getURL());
		Rakuun_Intern_Alliance_Security::pop();
		$users = Rakuun_Intern_Alliance_Security::getForAllianceById($this->getModule()->getParam('alliance'))->getPrivilegedUsers(Rakuun_Intern_Alliance_Security::PRIVILEGE_APPLICATIONS);
		foreach ($users as $user) {
			$igm = new Rakuun_Intern_IGM('Neue Bewerbung', $user);
			$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
			$igm->setText(
				'Hallo '.$user->name.',<br />'.
				$userlink->render().' hat sich bei deiner Allianz beworben.<br />'.
				$allianceModuleLink->render()
			);
			$igm->send();
		}
		DB_Connection::get()->commit();		
		$this->setSuccessMessage('Deine Bewerbung wurde abgeschickt.'); 
	}
}

?>