<?php

class Rakuun_Intern_Production_Building_Airport extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('airport');
		$this->setName('Flughafen');
		$this->setBaseIronCosts(1500);
		$this->setBaseBerylliumCosts(2000);
		$this->setBaseEnergyCosts(1000);
		$this->setBasePeopleCosts(20);
		$this->setBaseTimeCosts(10*60);
		$this->setMaximumLevel(50);
		$this->addNeededBuilding('military_base', 5);
		$this->addNeededTechnology('antigravitation', 1);
		$this->setShortDescription('Der Flughafen dient als Produktionsanlage und Start- und Landeplatz von Flugeinheiten.<br />Ein Ausbau bewirkt eine schnellere Produktion.');
		$this->setLongDescription('Flughäfen werden für die Konstruktion von Gleitern benötigt.
			<br/>
			Der Flughafen ist ein ziemlich hoher Komplex aus mehren turmartigen Gebilden zwischen denen einzelne Werftdocks an einem Gerüst angebracht sind. Die Türme sind auf verschiedene Bauteile spezialisiert wie Rumpf, Systeme, Waffen oder Anti-G-Einheit, während in den Docks diese Teile dann letztendlich zusammengeschraubt werden.
			<br/>
			Im Zentrum eines Flughafens findet man ein halbkugelförmiges Gebäude, in dem die Piloten während Stunden von Training in den Simulatoren das dreidimensionale Navigieren und Kämpfen in einem Anti-G Feld lernen.
			<br/>
			Nur eine kleine Schar von Leuten wird dann wirklich als Pilot akzeptiert. Ein guter Pilot benötigt nicht nur ausgezeichnete Reflexe und einen ausgeprägten Orientierungssinns, er muss auch nach stundenlangem Flug noch völlig konzentriert sein und auch psychologisch der Aufgabe gewachsen sein.
			<br/>
			Der Job eines Kampfpiloten kann mental Einfachere zermürben und wer nicht fähig ist, in einem Team zu kämpfen, taugt ebenfalls nichts.
			<br/>
			Nur wer sich nach jahrelangem Training bewährt hat, darf die Gerüste erklimmen und im Cockpit eines echten Kampfgleiters sitzen um seinen ersten Einsatz durchzuführen.');
		$this->setPoints(10);
	}
	
	protected function defineEffects() {
		$this->addEffect('Verkürzung der Produktionszeit von Flugeinheiten um insgesamt '.(self::PRODUCTION_TIME_REDUCTION_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
}

?>