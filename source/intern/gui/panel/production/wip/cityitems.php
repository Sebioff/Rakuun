<?php

class Rakuun_Intern_GUI_Panel_Production_WIP_CityItems extends Rakuun_Intern_GUI_Panel_Production_WIP {
	public function __construct($name, Rakuun_Intern_Production_Producer $producer, $title = '') {
		parent::__construct($name, $producer, $title);
		
		$wipItems = $this->getProducer()->getWIP();
		if ($wipItems) {
			$firstWIP = $wipItems[0];
			$this->contentPanel->cancel->setConfirmationMessage(
				'Wirklich abbrechen?\nEs werden 50% der Kosten erstattet:'.
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getIronRepayForLevel())).' Eisen'.
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getBerylliumRepayForLevel())).' Beryllium'.
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getEnergyRepayForLevel())).' Energie'.
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getPeopleRepayForLevel())).' Leute'
			);
		}
	}
	
	public function onCancel() {
		$wipItems = $this->getProducer()->getWIP();
		$firstWIP = $wipItems[0];
		DB_Connection::get()->beginTransaction();
		Rakuun_User_Manager::getCurrentUser()->ressources->raise($firstWIP->getIronRepayForLevel(), $firstWIP->getBerylliumRepayForLevel(), $firstWIP->getEnergyRepayForLevel(), $firstWIP->getPeopleRepayForLevel());
		foreach ($wipItems as $wipItem) {
			$wipItem->getRecord()->starttime = time();
			$wipItem->getRecord()->save();
		}
		$firstWIP->getRecord()->delete();
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>