<?php

abstract class Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorYellow extends Rakuun_Intern_Production_Building_Alliances_DatabaseDetector {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('database_detector_yellow');
		$this->setName('Datenbank-Detektor (Gelb)');
		$this->setShortDescription($this->getShortDescription().'Dieser Detektor macht das gelbe Datenbankteil sichtbar.');
	}
}

?>