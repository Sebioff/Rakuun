<?php

/**
 * Panel that displays the active relations of the actual alliance
 */
class Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_Actives extends Rakuun_Intern_GUI_Panel_Alliance_Diplomacy {
	private $actives = array();
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/actives.tpl');
		$own = Rakuun_User_Manager::getCurrentUser()->alliance;
		$this->actives = Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->select(array('conditions' => array(array('alliance_active = ? OR alliance_passive = ?', $own, $own), array('(status = ?) or (status = ? and date + (notice * 3600) > ?)', self::STATUS_ACTIVE, self::STATUS_DELETED, time()))));
		$_wars = array();
		$_naps = array();
		$_auvbs = array();
		$caption = '';
		foreach ($this->actives as $active) {
			$active->other = $active->allianceActive->getPK() == $own->getPK() ? $active->alliancePassive : $active->allianceActive;
			switch ($active->type) {
				case self::RELATION_AUVB:
					$_auvbs[] = $active;
					$caption = 'Kündigen';
				break;
				case self::RELATION_NAP:
					$_naps[] = $active;
					$caption = 'Kündigen';
				break;
				case self::RELATION_WAR:
					$_wars[] = $active;
					$caption = 'Beenden';
				break;
			}
			$this->addPanel($blanko = new GUI_Panel('blanko'.$active->getPK()));
			$blanko->addPanel(new GUI_Control_SecureSubmitButton('submit', $caption));
		}
		$this->params->auvbs = $_auvbs;
		$this->params->naps = $_naps;
		$this->params->wars = $_wars;
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		foreach ($this->actives as $active) {
			if ($this->{'blanko'.$active->getPK()}->hasBeenSubmitted()) {
				//mark a relation as deletable
				DB_Connection::get()->beginTransaction();
				$own = Rakuun_User_Manager::getCurrentUser()->alliance;
				$other = $active->other;
				$active->status = self::STATUS_DELETED;
				$active->date = time();
				unset($active->other);
				Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->save($active);
				$users = Rakuun_Intern_Alliance_Security::getForAlliance($other)->getPrivilegedUsers(Rakuun_Intern_Alliance_Security::PRIVILEGE_DIPLOMACY);
				$allianceLink = new Rakuun_GUI_Control_AllianceLink('alliancelink', $own);
				$diploLink = new GUI_Control_Link('diplomacylink', 'Diplomatie', App::get()->getInternModule()->getSubmodule('alliance')->getSubmodule('diplomacy')->getURL());
				foreach ($users as $user) {
					$igm = new Rakuun_Intern_IGM('Diplomatiebeziehung wurde gekündigt!', $user);
					$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
					$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
					$igm->setText(
						'Hallo '.$user->name.',<br />'.
						$allianceLink->render().' hat eure diplomatische Beziehung ('.$this->getNameForRelation($active->type).') aufgelöst!<br />'.
						'In '.Rakuun_Date::formatCountDown($active->notice * 60 * 60).' wird euer Status annuliert.<br />'.
						$diploLink->render()
					);
					$igm->send();
				}
				DB_Connection::get()->commit();
				$this->getModule()->invalidate();
				break;
			}
		}
	}
}

?>