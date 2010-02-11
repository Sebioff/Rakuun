<?php

class Rakuun_Intern_Module_Alliance extends Rakuun_Intern_Module_Alliance_Navigation {
	const FOUNDINGCOSTS_IRON = 100;
	const FOUNDINGCOSTS_BERYLLIUM = 100;
	
	public function __construct($name) {
		parent::__construct($name);
		
		// TODO totally stupid, has to be done in a different way, because:
		// for every single page load EVERY constructor of EVERY module is called,
		// thus the privileges for that submodule is checked on EVERY pageload
		// (even for not logged-in users!)
		
		if (Rakuun_User_Manager::getCurrentUser()) {
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Applications('applications'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Board('board'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Edit('edit'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Diplomacy('diplomacy'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Members('members'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Ranks('ranks'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Kick('kick'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Statistics('statistics'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Polls('polls'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Mail('mail'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Account('account'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Invite('invite'));
			$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Build('build'));
		}
	}
	
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/alliance.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($this->getParam('do') == md5('invite'.$user->nameUncolored.$this->getParam('id').$this->getParam('msgid'))) {
			if ($user->alliance) {
				$this->contentPanel->addError('Du bist schon ein einer Allianz. Wenn du deine Allianz wechseln willst musst du deine aktuelle Allianz erst verlassen.');
			} else {
				$options = array();
				$options['conditions'][] = array('user = ?', $user);
				$options['conditions'][] = array('id = ?', (int)$this->getParam('msgid'));
				$igm = Rakuun_DB_Containers::getMessagesContainer()->selectFirst($options);
				if ($igm) {
					$user->alliance = (int)$this->getParam('id');
					Rakuun_User_Manager::update($user);
					//delete the invitation message to avoid abuse
					Rakuun_DB_Containers::getMessagesContainer()->delete($igm);
					$this->invalidate();
				}
			}
		}
		
		if ($user->alliance != null)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Alliance_Profile_Own('profile'));
		else
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Alliance_Profile_None('profile'));
	}
}

?>