<?php

/**
 * TODO remove if it is absolutely clear that this won't be used anymore
 * @deprecated
 */
class Rakuun_Intern_Production_Technology_HeavyWeaponry extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('heavy_weaponry');
		$this->setName('Schwere Waffentechnik');
		$this->setBaseIronCosts(900);
		$this->setBaseBerylliumCosts(1100);
		$this->setBaseEnergyCosts(700);
		$this->setBasePeopleCosts(90);
		$this->setBaseTimeCosts(120*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_ATTACK);
		$this->addNeededBuilding('laboratory', 5);
		$this->addNeededBuilding('barracks', 3);
		$this->addNeededBuilding('tank_factory', 4);
		$this->addNeededTechnology('light_weaponry', 5);
		$this->setMaximumLevel(6);
		$this->setShortDescription('Fortgeschrittene Waffenkenntnisse, die für die Produktion von stärkeren Militäreinheiten benötigt werden.');
		$this->setLongDescription('Die schwere Waffentechnik bezieht sich auf Waffen, die eine hohe Durchschlagskraft haben, dafür eine relativ niedrige Schussfolge und ein langsames Handhaben.
			<br/>
			Einfache Fusstruppen sind meist zu agil um von solchen schweren Projektilen und Raketen getroffen zu werden, ebenso sind Gleiter einfach zu schwer zu treffen, besonders, da viele dieser Projektile (von Raketen abgesehen) nicht einmal in der Lage sind, auf die Höhe der Gleiter zu kommen.
			<br/>
			Langsame Panzer, an denen leichte Schüsse einfach abprallen, sind allerdings das ideale Ziel für diese Waffenklasse.');
		$this->setPoints(8);
	}
}

?>