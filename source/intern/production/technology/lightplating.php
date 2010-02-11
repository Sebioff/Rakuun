<?php

class Rakuun_Intern_Production_Technology_LightPlating extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('light_plating');
		$this->setName('Leichte Panzerung');
		$this->setBaseIronCosts(300);
		$this->setBaseBerylliumCosts(180);
		$this->setBaseEnergyCosts(200);
		$this->setBasePeopleCosts(100);
		$this->setBaseTimeCosts(90*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_DEFENSE);
		$this->addNeededBuilding('laboratory', 3);
		$this->addNeededBuilding('tank_factory', 1);
		$this->setMaximumLevel(5);
		$this->setShortDescription('Zur Produktion leicht gepanzerter Einheiten.');
		$this->setLongDescription('Die leichte Panzerung setzt auf einen eher leichten Schutz, der eine hohe Beweglichkeit erlaubt, sodass die damit ausgerüsteten Einheiten den Angriffen komplett ausweichen können, anstatt einfach den Schuss zu absorbieren.
			<br/>
			Meist wird eine einfache, stabile Schicht aus komprimiertem Kohlenstoff verwendet, die durch ihre enorme Leichtigkeit kaum Gewicht hat und trotz der Stabilität biegsam ist.');
		$this->setPoints(7);
	}
}

?>