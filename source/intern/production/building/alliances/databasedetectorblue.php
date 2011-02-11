<?php

class Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorBlue extends Rakuun_Intern_Production_Building_Alliances_DatabaseDetector {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('database_detector_blue');
		$this->setName('Datenbank-Detektor (Blau)');
		$this->setShortDescription($this->getShortDescription().'Dieser Detektor macht das blaue Datenbankteil sichtbar.');
	}
}

?>