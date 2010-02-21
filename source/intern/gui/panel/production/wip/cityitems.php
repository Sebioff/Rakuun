<?php

class Rakuun_Intern_GUI_Panel_Production_WIP_CityItems extends Rakuun_Intern_GUI_Panel_Production_WIP {
	public function __construct($name, Rakuun_Intern_Production_Producer $producer, $title = '') {
		parent::__construct($name, $producer, $title);
		
		$wipItems = $this->getProducer()->getWIP();
		if ($wipItems) {
			$firstWIP = $wipItems[0];
			$this->contentPanel->cancel->setConfirmationMessage(
				'Wirklich abbrechen?\nEs werden 50% der Kosten erstattet:'.
				'\n'.round($firstWIP->getIronRepayForLevel()).' Eisen'.
				'\n'.round($firstWIP->getBerylliumRepayForLevel()).' Beryllium'.
				'\n'.round($firstWIP->getEnergyRepayForLevel()).' Energie'.
				'\n'.round($firstWIP->getPeopleRepayForLevel()).' Leute'
			);
		}
	}
	
	public function onCancel() {
		$wipItems = $this->getProducer()->getWIP();
		$firstWIP = $wipItems[0];
		DB_Connection::get()->beginTransaction();
		Rakuun_User_Manager::getCurrentUser()->ressources->raise($firstWIP->getIronRepayForLevel(), $firstWIP->getBerylliumRepayForLevel(), $firstWIP->getEnergyRepayForLevel(), $firstWIP->getPeopleRepayForLevel());
		$firstWIP->getRecord()->delete();
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>