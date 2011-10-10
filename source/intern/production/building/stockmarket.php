<?php

class Rakuun_Intern_Production_Building_StockMarket extends Rakuun_Intern_Production_Building {
	/**
	 * defines how much the tradelimit increases by building the next stock market level
	 */
	const TRADELIMIT_PER_LEVEL = 2000;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('stock_market');
		$this->setName('Börse');
		$this->setBaseIronCosts(4000);
		$this->setBaseBerylliumCosts(3000);
		$this->setBaseEnergyCosts(2000);
		$this->setBasePeopleCosts(300);
		$this->setBaseTimeCosts(180*60);
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