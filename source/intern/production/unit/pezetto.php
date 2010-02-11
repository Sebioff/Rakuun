<?php

class Rakuun_Intern_Production_Unit_Pezetto extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('pezetto');
		$this->setName('Pezetto');
		$this->setNamePlural('Pezettos');
		$this->setBaseIronCosts(20);
		$this->setBaseBerylliumCosts(10);
		$this->setBasePeopleCosts(1);
		$this->setBaseTimeCosts(1*60);
		$this->setBaseDefenseValue(1);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY);
		$this->addNeededBuilding('barracks', 1);
		$this->setShortDescription('Pezetto');
		$this->setLongDescription('Von langen Schlachten in schwere Mitleidenschaft gezogen, ergriffen einige mutige Arbeiter primitive Waffen längst vergangener Tage wie Laserbohrer oder simple Halbautomatik-Waffen um dem Feind trotzen zu können.
			<br/>
			Da sich die Arbeiter größtenteils selbst verpflegen und ausrüsten, benötigt man für ihre Ausbildung nur geringe Ressourcenmengen für Waffen und eine simple Grundkampfschulung.
			<br/>
			Ihre billige Ausbildung macht, strategisch gesehen, ihre fehlende Kampfkraft wett. Die Arbeiter sind aber immer noch Arbeiter, die sich nur verteidigen wollen und somit nicht als Angriffseinheit fungieren. Desweiteren gibt es unter den Arbeitern in Friedenszeiten kein Bestreben, die Waffe zu ergreifen, im Gegenteil, Pezettos legen nach einiger Zeit geleistetem Dienst wieder ihre Waffe nieder.');
	}
}

?>