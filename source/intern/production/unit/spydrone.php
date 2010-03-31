<?php

class Rakuun_Intern_Production_Unit_Spydrone extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('spydrone');
		$this->setName('Spionagesonde');
		$this->setNamePlural('Spionagesonden');
		$this->setBaseIronCosts(100);
		$this->setBaseBerylliumCosts(100);
		$this->setBaseEnergyCosts(100);
		$this->setBaseTimeCosts(3*60);
		$this->setBaseSpeed(15);
		$this->addNeededBuilding('barracks', 3);
		$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK, true);
		$this->setShortDescription('Spionagesonde');
		$this->setLongDescription('Spionagesonden beruhen auf der ziemlich alten Technik des Etherstreams.
			<br/>
			Geleitet von einer unbekannten Kraft erreichen sie gigantische Geschwindigkeiten, können danach allerdings nicht mehr bremsen und fliegen, nachdem sie von der anvisierten Stadt Aufzeichnungen gemacht haben, weiter in Richtung Weltraum um dort durch den Unterdruck zu explodieren.
			<br/>
			Die Etherstream Technologie eignet sich daher nicht für wirkliche Kampfeinheiten; die Wissenschaft wäre noch nichtmal in der Lage, Streamgeneratoren für wesentlich größere Gebilde zu bauen.
			<br/>
			<br/>
			Spionagesonden können mit der Verbesserten Tarnung ausgestattete Einheiten nicht erkennen.');
	}
}

?>