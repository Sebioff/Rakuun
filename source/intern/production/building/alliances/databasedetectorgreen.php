<?php

abstract class Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorGreen extends Rakuun_Intern_Production_Building_Alliances_DatabaseDetector {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('database_detector_green');
		$this->setName('Datenbank-Detektor (Grün)');
		$this->setShortDescription($this->getShortDescription().'Dieser Detektor macht das grüne Datenbankteil sichtbar.');
	}
}

?>