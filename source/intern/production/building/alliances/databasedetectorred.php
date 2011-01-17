<?php

abstract class Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorRed extends Rakuun_Intern_Production_Building_Alliances_DatabaseDetector {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('database_detector_red');
		$this->setName('Datenbank-Detektor (Rot)');
		$this->setShortDescription($this->getShortDescription().'Dieser Detektor macht das rote Datenbankteil sichtbar.');
	}
}

?>