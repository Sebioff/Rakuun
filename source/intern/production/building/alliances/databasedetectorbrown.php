<?php

abstract class Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorBrown extends Rakuun_Intern_Production_Building_Alliances_DatabaseDetector {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('database_detector_brown');
		$this->setName('Datenbank-Detektor (Braun)');
		$this->setShortDescription($this->getShortDescription().'Dieser Detektor macht das braune Datenbankteil sichtbar.');
	}
}

?>