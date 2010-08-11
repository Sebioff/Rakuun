<?php

class Rakuun_Intern_Production_WIP_CityItem extends Rakuun_Intern_Production_WIP {
	public function init() {
		parent::init();
		$this->cancel->setConfirmationMessage(
			'Wirklich abbrechen?\nEs werden 50% der Kosten erstattet:'.
			'\n'.GUI_Panel_Number::formatNumber(round($this->getWIPItem()->getIronRepayForLevel())).' Eisen'.
			'\n'.GUI_Panel_Number::formatNumber(round($this->getWIPItem()->getBerylliumRepayForLevel())).' Beryllium'.
			'\n'.GUI_Panel_Number::formatNumber(round($this->getWIPItem()->getEnergyRepayForLevel())).' Energie'.
			'\n'.GUI_Panel_Number::formatNumber(round($this->getWIPItem()->getPeopleRepayForLevel())).' Leute'
		);
	}
}

?>