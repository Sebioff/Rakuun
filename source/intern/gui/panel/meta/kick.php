<?php

/**
 * Panel with links to kick alliances from a meta
 */
class Rakuun_Intern_GUI_Panel_Meta_Kick extends GUI_Panel {
	private $alliances = array();
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/kick.tpl');
		$options['conditions'][] = array('id != ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$options['order'] = 'name ASC';
		$this->alliances = Rakuun_User_Manager::getCurrentUser()->alliance->meta->alliances->select($options);
		foreach ($this->alliances as $alliance) {
			$this->addPanel($blanko = new GUI_Panel('blanko'.$alliance->getPK()));
			$blanko->addPanel($kickbutton = new GUI_Control_SecureSubmitButton('kick', 'Kicken'));
			$kickbutton->setConfirmationMessage('Willst du ['.$alliance->tag.'] '.$alliance->name.' wirklich kicken?');
		}
	}
	
	public function onKick() {
		if ($this->hasErrors())
			return;
		
		foreach ($this->alliances as $alliance) {
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
	
	public function onDelete() {
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		$ids = array();
		$str = '';
		foreach ($this->list->getSelectedItems() as $item) {
			if ($item->getValue() != Rakuun_User_Manager::getCurrentUser()->alliance->getPK()) {
				$ids[] = $item->getValue();
				$str .= '?, ';
			}
		}
		if (!empty($ids)) {
			$currentUserLink = new Rakuun_GUI_Control_UserLink('userlink', Rakuun_User_Manager::getCurrentUser());
			$metaLink = new GUI_Control_Link('meta', 'Metas', App::get()->getInternModule()->getSubmodule('meta')->getURL());
			$options['conditions'][] = array_merge(array('´id´ in ('.substr($str, 0, -2).')'), $ids);
			$options['conditions'][] = array('meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
			$alliances = Rakuun_DB_Containers::getAlliancesContainer()->select($options);
			foreach ($alliances as $alliance) {
				$users = Rakuun_Intern_Alliance_Security::getForAlliance($alliance)->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
				foreach ($users as $user) {
					$igm = new Rakuun_Intern_IGM('Kick aus Meta', $user);
					$igm->type = Rakuun_Intern_IGM::TYPE_META;
					$igm->setSenderName(Rakuun_Intern_IGM::SENDER_META);
					$igm->setText(
						'Deine Allianz wurde von '.$userlink->render().' aus der Meta '.$user->alliance->meta->name.' gekickt!<br />'.
						$metalink->render()
					);
					$igm->send();
				}
				//kick the alliance from meta
				$alliance->meta = null;
				Rakuun_DB_Containers::getAlliancesContainer()->save($alliance);
			}
		}
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>