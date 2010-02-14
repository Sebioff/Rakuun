<?php

class Rakuun_Intern_Production_Building_MilitaryBase extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('military_base');
		$this->setName('Militärstützpunkt');
		$this->setBaseIronCosts(1000);
		$this->setBaseBerylliumCosts(500);
		$this->setBasePeopleCosts(35);
		$this->setBaseTimeCosts(10*60);
		$this->setMaximumLevel(50);
		$this->addNeededBuilding('ironmine', 2);
		$this->addNeededBuilding('berylliummine', 1);
		$this->setShortDescription('Der Militärstützpunkt ist sowohl Versammlungsort aller militärischen Einheiten, als auch der "Bauplatz" (und somit eine Grundvorraussetzung) für alle militärischen Gebäude.');
		$this->setLongDescription('Der Militärstützpunkt ist der Platz, auf dem alle militärischen Gebäude stehen.
			<br/>
			Er ist auch der Sammelpunkt für alle Boden- und Lufteinheiten.');
		$this->setPoints(10);
	}
	
	protected function defineEffects() {
		$this->addEffect('Verkürzung der Produktionszeit von hier produzierten Einheiten um insgesamt '.(self::PRODUCTION_TIME_REDUCTION_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
}

?>