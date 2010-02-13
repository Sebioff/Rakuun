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
		$this->setShortDescription('Der Datenbank-Detektor wird benötigt, um die Datenbankteile finden und transportieren zu können.<br />Pro Ausbaustufe wird ein weiteres Datenbankteil sichtbar und kann erobert werden.');
	}
}

?>