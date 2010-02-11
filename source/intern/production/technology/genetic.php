<?php

class Rakuun_Intern_Production_Technology_Genetic extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('genetic');
		$this->setName('Gentechnik');
		$this->setBaseIronCosts(800);
		$this->setBaseBerylliumCosts(800);
		$this->setBaseEnergyCosts(1000);
		$this->setBaseTimeCosts(720*60);
		$this->addNeededBuilding('laboratory', 2);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Durch die Gentechnik können Clon-O-Maten gebaut werden, welche die "Produktion" von Rakuuranern erhöhen.');
		$this->setLongDescription('Die Klonung eines Wesens an sich stellt wohl das geringste Problem dar.
			<br/>
			Was an dieser Technik wohl das schwerste ist, ist die Verschmelzung und Ausbesserung des Erbgutes sowie die Nährstoffzuflußkontrolle, die ein schnelles Wachstum ermöglicht.
			<br/>
			Natürlich sollen letztendlich leistungsfähige Arbeiter und Krieger rauskommen, daher ist es unumgänglich, das Erbgut an einigen Stellen zu verbessern.
			<br/>
			Die in kürzester Zeit gezüchteten Wesen verfügen noch über sehr wenig Wissen und müssen so schnell wie möglich eingeschult werden, was eine verbesserte Hirnleistung nötig macht.
			<br/>
			Auch hatten die Klone keine Zeit, Muskeln zu trainieren und müssen daher mit den modernsten Steroiden hochgepowert werden.');
		$this->setPoints(8);
	}
}

?>