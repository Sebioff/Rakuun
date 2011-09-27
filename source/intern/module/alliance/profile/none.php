<?php

class Rakuun_Intern_Module_Alliance_Profile_None extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		// invite an user per invite-mail
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($this->getParam('do') == md5('invite'.$user->nameUncolored.$this->getParam('id').$this->getParam('msgid'))) {
			if ($user->alliance) {
				$this->contentPanel->addError('Du bist schon ein einer Allianz. Wenn du deine Allianz wechseln willst musst du deine aktuelle Allianz erst verlassen.');
			}
			elseif (!Rakuun_GameSecurity::get()->hasPrivilege($user, Rakuun_GameSecurity::PRIVILEGE_JOIN_ALLIANCES)) {
				$this->contentPanel->addError('Du kannst mit diesem Account keiner anderen Allianz beitreten');
			}
			else {
				$options = array();
				$options['conditions'][] = array('user = ?', $user);
				$options['conditions'][] = array('id = ?', (int)$this->getParam('msgid'));
				$igm = Rakuun_DB_Containers::getMessagesContainer()->selectFirst($options);
				if ($igm) {
					$user->alliance = (int)$this->getParam('id');
					Rakuun_User_Manager::update($user);
					//delete the invitation message to avoid abuse
					Rakuun_DB_Containers::getMessagesContainer()->delete($igm);
					//save alliancehistory
					$alliance = Rakuun_DB_Containers::getAlliancesContainer()->selectByIDFirst((int)$this->getParam('id'));
					$alliancehistory = new Rakuun_Intern_Alliance_History($user, $alliance->name, Rakuun_Intern_Alliance_History::TYPE_JOIN);
					$alliancehistory->save();
					
					$this->redirect(App::get()->getInternModule()->getSubmodule('alliance')->getURL());
				}
			}
		}
		
		$this->setPageTitle('Allianz gründen');
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Alliance_Profile_None('profile'));
	}
}
?>