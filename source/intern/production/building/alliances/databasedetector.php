<?php

class Rakuun_Intern_Production_Building_Alliances_DatabaseDetector extends Rakuun_Intern_Production_AllianceBuilding {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('database_detector');
		$this->setName('Datenbank-Detektor');
		$this->setBaseIronCosts(10000);
		$this->setBaseBerylliumCosts(10000);
		$this->setBaseTimeCosts(24*60*60);
		$this->setMaximumLevel(5);
		// TODO add proper short description
		$this->setShortDescription('Der Flughafen dient als Produktionsanlage und Start- und Landeplatz von Flugeinheiten.<br />Ein Ausbau bewirkt eine schnellere Produktion.');
	}
}

?>