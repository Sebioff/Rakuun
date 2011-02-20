<?php

class Rakuun_Intern_Production_Unit_Mandrogani extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('mandrogani');
		$this->setName('Mandrogani');
		$this->setNamePlural('Mandroganis');
		$this->setBaseIronCosts(600);
		$this->setBaseBerylliumCosts(650);
		$this->setBaseEnergyCosts(700);
		$this->setBasePeopleCosts(30);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseAttackValue(44);
		$this->setBaseDefenseValue(14);
		$this->setBaseSpeed(150);
		$this->setRessourceTransportCapacity(350);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededBuilding('tank_factory', 4);
		$this->addNeededTechnology('heavy_weaponry', 1);
		$this->addNeededTechnology('light_plating', 4);
		$this->addNeededTechnology('engine', 3);
		$this->addNeededTechnology('laser', 3);
		$this->addNeededTechnology('cloaking', 2);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->setAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_CLOAKING, true);
		$this->setShortDescription('Mandrogani');
		$this->setLongDescription('Der Mandrogani ist so ziemlich das weitentwickelste an Technik, was man auf dem Schlachtfeld antreffen kann.
			<br/>
			Für einen Panzer seiner Größe scheint er nur unzureichend gepanzert zu sein, doch seine Technik macht das wieder wett: er verwendet modernste Lasertechnik, mit dem er im Kampf eine Allrounder-Eigenschaft hat, da der sowohl schnelle wie auch starke Laser gegen jeden Typ von Einheit einsetzbar ist.
			<br/>
			Desweiteren besitzt dieser Panzer eine Tarnvorrichtung, die es ihm erlaubt, sowohl schwer vorhersehbare Angriffe durchzuführen, als auch auf dem Schlachtfeld für eine Täuschung des Gegners zu sorgen.
			<br/>
			Leider benötigen die Vorrichtung und der Laser eine Aufwärmzeit, sodass der Mandrogani gewaltige Abstriche im Verteidigungsfall erleiden muss.');
	}
}

?>