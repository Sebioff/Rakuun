<?php

class Rakuun_Intern_Production_Building_MilitaryBase extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('military_base');
		$this->setName('Militärstützpunkt');
		$this->setBaseIronCosts(1200);
		$this->setBaseBerylliumCosts(1200);
		$this->setBaseEnergyCosts(1200);
		$this->setBasePeopleCosts(16);
		$this->setBaseTimeCosts(12*60);
		$this->setMaximumLevel(50);
		$this->setShortDescription('Der Militärstützpunkt ist sowohl Versammlungsort aller militärischen Einheiten, als auch der "Bauplatz" (und somit eine Grundvoraussetzung) für alle militärischen Gebäude.');
		$this->setLongDescription('Der Militärstützpunkt ist der Platz, auf dem alle militärischen Gebäude stehen.
			<br/>
			Er ist auch der Sammelpunkt für alle Boden- und Lufteinheiten.');
		$this->setPoints(10);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verkürzung der Produktionszeit von hier produzierten Einheiten um insgesamt '.$this->getProductionTimeReductionPercent($futureLevel + 1).'% (vorher: '.$this->getProductionTimeReductionPercent($futureLevel).'%)');
	}
	
	private function getProductionTimeReductionPercent($level) {
		return self::PRODUCTION_TIME_REDUCTION_PERCENT * $level;
	}
}

?>