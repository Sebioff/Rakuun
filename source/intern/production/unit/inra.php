<?php

class Rakuun_Intern_Production_Unit_Inra extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('inra');
		$this->setName('Infanterie-Rakuuraner');
		$this->setNamePlural('Infanterie-Rakuuraner');
		$this->setBaseIronCosts(250);
		$this->setBaseBerylliumCosts(750);
		$this->setBaseEnergyCosts(500);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseAttackValue(8);
		$this->setBaseDefenseValue(22);
		$this->setBaseSpeed(160);
		$this->setRessourceTransportCapacity(100);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER);
		$this->addNeededBuilding('barracks', 1);
		$this->addNeededTechnology('cybernetics', 1);
		$this->setShortDescription('Inra');
		$this->setLongDescription('Infanterie-Rakuuraner, auch Inras genannt, bilden das Rückgrat der meisten Armeen.
			<br/>
			Ausgestattet mit einfachen Gaussgewehren sind sie in der Lage, stabilste Hüllen zu durchdringen.
			<br/>
			Inras sind hart geschult und laufen mit schwersten Verletzungen noch über die Kampfesfelder um noch soviele Gegner mitzureißen wie möglich.
			<br/>
			Da sie allerdings nicht motorisiert sind, haben sie eine relativ langsame Geschwindigkeit und sind deshalb für schnelle Schlachten weniger geeignet.');
	}
}

?>