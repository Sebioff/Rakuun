<?php

class Rakuun_Intern_Production_Building_StockMarket extends Rakuun_Intern_Production_Building {
	/**
	 * defines how much the tradelimit increases by building the next stock market
	 * level */
	const TRADELIMIT_PER_LEVEL = 4000;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('stock_market');
		$this->setName('Börse');
		$this->setBaseIronCosts(3200);
		$this->setBaseBerylliumCosts(2400);
		$this->setBaseEnergyCosts(1600);
		$this->setBasePeopleCosts(240);
		$this->setBaseTimeCosts(80*60);
		$this->addNeededBuilding('hydropower_plant', 3);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->setMaximumLevel(10);
		$this->setShortDescription('Die Börse - ein großer Umschlagplatz für Eisen, Beryllium und Energie.<br />Durch den Ausbau wird die maximale täglich umtauschbare Ressourcenmenge erhöht.');
		$this->setLongDescription('Die Börse wird zum Umtausch von Ressourcen eines Types in einen anderen Typ genutzt.
			<br/>
			Das Umtauschverhältnis wird dabei durch Angebot und Nachfrage bestimmt. Durch Platzmangel und logistische Probleme, die bei der Beförderung großer Mengen an Rohstoffen entstehen, ist die maximale tägliche Umtauschmenge begrenzt.
			<br/>
			In früheren Zeiten wurden diese Tauschgeschäfte über einen simplen Markt durchgeführt. Betrüger, Kleinkriminelle, Halsabschneider und politische Spannungen führten später jedoch zur Entwicklung des heute genutzten Börsensystems, das neutralen Handel erlaubt.');
		$this->setPoints(7);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöhung der umtauschbaren Ressourcen pro Tag um '.Text::formatNumber(Rakuun_Intern_Production_Building_StockMarket::TRADELIMIT_PER_LEVEL * RAKUUN_TRADELIMIT_MULTIPLIER));
	}
}

?>