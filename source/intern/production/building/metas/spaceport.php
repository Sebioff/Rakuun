<?php

class Rakuun_Intern_Production_Building_Metas_SpacePort extends Rakuun_Intern_Production_MetaBuilding {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('space_port');
		$this->setName('Dancertia-Raumhafen');
		$this->setBaseIronCosts(200000);
		$this->setBaseBerylliumCosts(200000);
		$this->setBaseEnergyCosts(100000);
		$this->setBasePeopleCosts(20000);
		$this->setBaseTimeCosts(36*60*60);
		$this->setMaximumLevel(1);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_Meta_GotDatabases());
		$this->setShortDescription('Der Dancertia-Raumhafen wird für den Bau der Dancertia benötigt. Sobald der Raumhafen fertiggestellt ist,<br/> können die Mitglieder der Meta Schildgeneratoren bauen, welche den Raumhafen vor Angreifern schützen.');
	}
}

?>