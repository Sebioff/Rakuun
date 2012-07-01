<?php

class Rakuun_Intern_Production_Unit_Mandrogani extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('mandrogani');
		$this->setName('Mandrogani');
		$this->setNamePlural('Mandroganis');
		$this->setBaseIronCosts(525);
		$this->setBaseBerylliumCosts(525);
		$this->setBaseEnergyCosts(550);
		$this->setBasePeopleCosts(15);
		$this->setBaseTimeCosts(17*60+30);
		$this->setBaseAttackValue(15);
		$this->setBaseDefenseValue(15);
		$this->setBaseSpeed(160);
		$this->setRessourceTransportCapacity(100);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededBuilding('tank_factory', 15);
		$this->addNeededTechnology('light_plating', 3);
		$this->addNeededTechnology('cloaking', 1);
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