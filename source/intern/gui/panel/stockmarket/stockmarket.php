<?php

class Rakuun_Intern_GUI_Panel_StockMarket extends GUI_Panel {
	/**
	 * BASE_* used for game-reset only
	 */
	const BASE_IRON = 10000000;
	const BASE_BERYLLIUM = 10000000;
	const BASE_ENERGY = 5000000;
	
	const MAX_EXCHANGE_COURSE = 4;
	const MIN_EXCHANGE_COURSE = 0.25;
		
	const RESSOURCE_IRON = 1;
	const RESSOURCE_BERYLLIUM = 2;
	const RESSOURCE_ENERGY = 3;
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/stockmarket.tpl');
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'handeln'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->getModule()->addJsAfterContent("$('#".$this->first_radio->getID()."').hide(); $('#".$this->second_radio->getID()."').hide();");
	}
	
	/**
	 * get the amount of ressources tradable
	 * @return array with self::RESSOURCE_* as index
	 */
	public static function getStockRessources() {
		$options = array();
		$options['order'] = 'date DESC';
		$ressources = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		return array(
			self::RESSOURCE_IRON => $ressources->iron,
			self::RESSOURCE_BERYLLIUM => $ressources->beryllium,
			self::RESSOURCE_ENERGY => $ressources->energy);
	}
	
	protected function checkTradable($amount) {
		$user = Rakuun_User_Manager::getCurrentUser();
		$tradable = self::getTradable();
		if ($user->isInNoob()) {
			$this->addError('Du befindest dich im Noobschutz und darfst die Börse daher nicht nutzen!');
		}
		if ($amount > $tradable) {
			$this->addError('Du kannst maximal '.GUI_Panel_Number::formatNumber($tradable).' Ressourcen pro Tag über die Börse handeln.');
		}
		if ($amount > $tradable - $user->stockmarkettrade) {
			$this->addError('Du kannst heute nur noch '.GUI_Panel_Number::formatNumber(self::getTradableLeft()).' Ressourcen über die Börse handeln.');
		}
	}
	
	protected function checkCapacities($iron, $beryllium, $energy) {
		$user = Rakuun_User_Manager::getCurrentUser();
		$pool = self::getStockRessources();
		if ($iron > 0) {
			// user gets iron
			if (!$user->ressources->gotEnoughCapacity($iron))
				$this->addError('So viel Eisen kannst du nicht mehr einlagern!');
			if ($pool[self::RESSOURCE_IRON] < $iron)
				$this->addError('So viel Eisen ist nicht mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with iron
			if ($user->ressources->iron < $iron * -1)
				$this->addError('So viel Eisen hast du nicht!');
		}
		if ($beryllium > 0) {
			// user gets beryllium
			if (!$user->ressources->gotEnoughCapacity($beryllium))
				$this->addError('So viel Beryllium kannst du nicht mehr einlagern!');
			if ($pool[self::RESSOURCE_BERYLLIUM] < $beryllium)
				$this->addError('So viel Beryllium ist nicht mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with beryllium
			if ($user->ressources->beryllium < $beryllium * -1)
				$this->addError('So viel Beryllium hast du nicht!');
		}
		if ($energy > 0) {
			// user gets energy
			if (!$user->ressources->gotEnoughCapacity($energy))
				$this->addError('So viel Energie kannst du nicht mehr einlagern!');
			if ($pool[self::RESSOURCE_ENERGY] < $energy)
				$this->addError('So viel Energie ist nicht mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with energy
			if ($user->ressources->energy < $energy * -1)
				$this->addError('So viel Energie hast du nicht!');
		}
	}
	
	protected static function getTradable() {
		return Rakuun_User_Manager::getCurrentUser()->buildings->stockMarket * Rakuun_Intern_Production_Building_StockMarket::TRADELIMIT_PER_LEVEL * RAKUUN_TRADELIMIT_MULTIPLIER;
	}
	
	public static function getTradableLeft() {
		return self::getTradable() - Rakuun_User_Manager::getCurrentUser()->stockmarkettrade;
	}
}
?>