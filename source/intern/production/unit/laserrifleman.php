<?php

class Rakuun_Intern_Production_Unit_LaserRifleman extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laser_rifleman');
		$this->setName('Laserschütze');
		$this->setNamePlural('Laserschützen');
		$this->setBaseIronCosts(480);
		$this->setBaseBerylliumCosts(320);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(8);
		$this->setBaseTimeCosts(16*60);
		$this->setBaseAttackValue(22);
		$this->setBaseDefenseValue(8);
		$this->setBaseSpeed(110);
		$this->setRessourceTransportCapacity(50);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER);
		$this->addNeededBuilding('barracks', 1);
		$this->addNeededTechnology('laser', 1);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->setShortDescription('Laserschütze');
		$this->setLongDescription('Laserschützen sind die Weiterentwicklung der Inras.
			<br/>
			Bewaffnet mit stahlschneidenden Lasern modernster Technologie sind sie um einiges effektiver im Kampf als ihre relativ primitiven Vorgänger.
			<br/>
			Ihre Gewehre benötigen allerdings eine Menge moderner Baustoffe wie Beryllium und müssen zudem mit Energie geladen werden, was viele Armeebesitzer vor ihrer Anschaffung zurückschrecken lässt. Ein weiterer Nachteil ist die im Vergleich zu Inras längere Ausbildungszeit.
			<br/>
			Da die Effektivität von Laserschützen mit der Erforschungsstufe der Lasertechnologie ansteigt, können sie aber durchaus eine lohnenswerte Ergänzung der Streitkräfte sein.');
	}
}

?>