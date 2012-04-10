<?php

/**
 * TODO remove if it is absolutely clear that this won't be used anymore
 * @deprecated
 */
class Rakuun_Intern_Production_Technology_HeavyPlating extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('heavy_plating');
		$this->setName('Schwere Panzerung');
		$this->setBaseIronCosts(1300);
		$this->setBaseBerylliumCosts(800);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(120);
		$this->setBaseTimeCosts(300*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_DEFENSE);
		$this->addNeededBuilding('laboratory', 6);
		$this->addNeededBuilding('tank_factory', 6);
		$this->addNeededTechnology('light_plating', 4);
		$this->setMaximumLevel(4);
		$this->setShortDescription('Zur Produktion stark gepanzerter Einheiten.');
		$this->setLongDescription('Schwere Panzerung ist meist so stabil und mehrschichtig konfiguriert, dass selbst die härtesten Schüsse einfach an ihr abprallen.
			<br/>
			Dafür benötigt es mehrere, dicke und dichte Schichten härtester Metalle wie Titan, die ein enormes Gewicht haben.
			<br/>
			Daher sind besonders die ultraschwer gepanzerten Buhoganis unglaublich langsam und kaum in der Lage, Angriffen auszuweichen.');
		$this->setPoints(10);
	}
}

?>