<?php
/**
 * Panel to display the diplomacies from extern view
 */
class Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_Overview extends Rakuun_Intern_GUI_Panel_Alliance_Diplomacy {
	
	public function init() {
		parent::init();
		
		$own = Rakuun_DB_Containers::getAlliancesContainer()->selectByPK(Router::get()->getCurrentModule()->getParam('alliance'));
		
		$this->setTemplate(dirname(__FILE__).'/overview.tpl');
		$actives = Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->select(array('conditions' => array(array('alliance_active = ? OR alliance_passive = ?', $own, $own), array('(status = ?) OR (status = ? AND date + (notice * 3600) > ?)', self::STATUS_ACTIVE, self::STATUS_DELETED, time()))));
		$_wars = array();
		$_naps = array();
		$_auvbs = array();
		foreach ($actives as $active) {
			$active->other = $active->allianceActive->getPK() == $own->getPK() ? $active->alliancePassive : $active->allianceActive;
			switch ($active->type) {
				case self::RELATION_AUVB:
					$_auvbs[] = $active;
				break;
				case self::RELATION_NAP:
					$_naps[] = $active;
				break;
				case self::RELATION_WAR:
					$_wars[] = $active;
				break;
			}
		}
		$this->params->auvbs = $_auvbs;
		$this->params->naps = $_naps;
		$this->params->wars = $_wars;		
	}
}
?>