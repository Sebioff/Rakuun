<?php

class Rakuun_Intern_Production_Building_ShieldGenerator extends Rakuun_Intern_Production_Building {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('shield_generator');
		$this->setName('Schildgenerator');
		$this->setBaseIronCosts(50000);
		$this->setBaseBerylliumCosts(50000);
		$this->setBaseEnergyCosts(5000);
		$this->setBasePeopleCosts(30000);
		$this->setBaseTimeCosts(4*60*60);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_GotDatabases());
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_Meta_GotSpacePort());
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_Meta_GotNoDancertia());
		$this->setMaximumLevel(1);
		$this->setShortDescription('Der Schildgenerator erzeugt einen riesigen Schutzschild über dem Dancertia-Raumhafen der Meta-Allianz. Solange mindestens ein Generator in Betrieb ist, wird es für feindliche Angreifer unmöglich sein, dass dort im Bau befindliche Raumschiff, die "Dancertia", zu zerstören.<br/>Sobald sich die "Dancertia" im Bau befindet, können keine Schildgeneratoren mehr gebaut werden.');
		$this->setPoints(15);
	}
}

?>