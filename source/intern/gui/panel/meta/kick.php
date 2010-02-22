<?php

/**
 * Panel with links to kick alliances from a meta
 */
class Rakuun_Intern_GUI_Panel_Meta_Kick extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/kick.tpl');
		$options['conditions'][] = array('id != ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$options['order'] = 'name ASC';
		$this->params->alliances = Rakuun_User_Manager::getCurrentUser()->alliance->meta->alliances->select($options);
		foreach ($this->params->alliances as $alliance) {
			$this->addPanel($blanko = new GUI_Panel('blanko'.$alliance->getPK()));
			$blanko->addPanel($kickbutton = new GUI_Control_SecureSubmitButton('kick', 'Kicken'));
			$kickbutton->setConfirmationMessage('Willst du ['.$alliance->tag.'] '.$alliance->name.' wirklich kicken?');
		}
	}
	
	public function onKick() {
		if ($this->hasErrors())
			return;
		
		foreach ($this->params->alliances as $alliance) {
			if ($this->{'blanko'.$alliance->getPK()}->hasBeenSubmitted()) {
				DB_Connection::get()->beginTransaction();
				$currentUserLink = new Rakuun_GUI_Control_UserLink('userlink', Rakuun_User_Manager::getCurrentUser());
				$currentUserAllianceLink = new Rakuun_GUI_Control_AllianceLink('alliancelink', Rakuun_User_Manager::getCurrentUser()->alliance);
				$metaLink = new GUI_Control_Link('meta', 'Metas', App::get()->getInternModule()->getSubmodule('meta')->getURL());
				$users = Rakuun_Intern_Alliance_Security::getForAlliance($alliance)->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
				foreach ($users as $user) {
					$igm = new Rakuun_Intern_IGM('Kick aus Meta', $user);
					$igm->type = Rakuun_Intern_IGM::TYPE_META;
					$igm->setSenderName(Rakuun_Intern_IGM::SENDER_META);
					$igm->setText(
						'Deine Allianz wurde von '.$currentUserAllianceLink->render().' '.$currentUserLink->render().' aus der Meta '.$user->alliance->meta->name.' gekickt!<br />'.
						$metaLink->render()
					);
					$igm->send();
				}
				//kick the alliance from meta
				$alliance->meta = null;
				Rakuun_DB_Containers::getAlliancesContainer()->save($alliance);
				DB_Connection::get()->commit();
				$this->getModule()->invalidate();
			}
		}
	}
}

?>