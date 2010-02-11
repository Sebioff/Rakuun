<?php

/**
 * Panel with links to kick users from your alliance
 */
class Rakuun_Intern_GUI_Panel_Alliance_Kick extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/kick.tpl');
		$this->params->members = Rakuun_User_Manager::getCurrentUser()->alliance->members;
		foreach ($this->params->members as $member) {
			$this->addPanel($blanko = new GUI_Panel('blanko'.$member->getPK()));
			$blanko->addPanel($kickbutton = new GUI_Control_SecureSubmitButton('kick', 'kicken'));
			$kickbutton->setTitle($member->nameUncolored);
			$kickbutton->setConfirmationMessage('Willst du '.$member->nameUncolored.' wirklich kicken?');
			$blanko->addPanel(new GUI_Control_HiddenBox('id', $member->getPK()));
		}
	}
	
	public function onKick() {
		if ($this->hasErrors())
			return;
			
		foreach ($this->params->members as $member) {
			if ($this->{'blanko'.$member->getPK()}->hasBeenSubmitted()) {
				//Check requirements to kick the user
				DB_Connection::get()->beginTransaction();
				$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->{'blanko'.$member->getPK()}->id->getValue(), array('conditions' => array(array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance))));
				if (!$user) {
					$this->addError('Dieser User gehört nicht zu deiner Allianz!');
					DB_Connection::get()->rollback();
					return;
				}
				if ($user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK()) {
					$this->addError('Sich selbst kicken? Persönlichkeitsstörung? :D');
					DB_Connection::get()->rollback();
					return;
				}
				if (Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)) {
					$this->addError('Dieser User ist in der Leiter-Gruppe und kann daher nicht gekickt werden!');
					DB_Connection::get()->rollback();
					return;
				}
				//delete users privileges
				Rakuun_Intern_Alliance_Security::get()->getContainerGroupsUsersAssoc()->deleteByUser($user);
				//send information message to the user
				$allianceLink = new Rakuun_GUI_Control_AllianceLink('alliancelink', Rakuun_User_Manager::getCurrentUser()->alliance);
				$aktUserLink = new Rakuun_GUI_Control_UserLink('userlink', Rakuun_User_Manager::getCurrentUser());
				$allianceModuleLink = new GUI_Control_Link('allianceslink', 'Allianzen', App::get()->getInternModule()->getSubmodule('alliance')->getURL());
				$igm = new Rakuun_Intern_IGM('Kick aus Allianz', $user);
				$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
				$igm->setText(
					'Du wurdest von '.$aktUserLink->render().' aus der Allianz '.$allianceLink->render().' gekickt!<br />'.
					$allianceModuleLink->render()
				);
				$igm->send();
				//kick the user from alliance
				$user->alliance = null;
				Rakuun_User_Manager::update($user);
				$this->getModule()->invalidate();
				DB_Connection::get()->commit();
			}
		}
	}
}

?>