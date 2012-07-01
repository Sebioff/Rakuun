<?php

class Rakuun_Intern_Production_Technology_EnhancedCloaking extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('enhanced_cloaking');
		$this->setName('Verbesserte Tarnung');
		$this->setBaseIronCosts(25000);
		$this->setBaseBerylliumCosts(25000);
		$this->setBaseEnergyCosts(25000);
		$this->setBasePeopleCosts(10000);
		$this->setBaseTimeCosts(7*24*60*60 + 12*60*60); //7d 12h 00min
		$this->addNeededBuilding('laboratory', 20);
		$this->addNeededTechnology('sensor_technology', 3);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Durch die Verbesserte Tarnung sind Tarneinheiten in gegnerischen Spionageberichten, die von normalen Sonden erstellt wurden, absolut unsichtbar. Lediglich Tarnsonden können Einheiten, die mit der Verbesserten Tarnung ausgestattet sind, entdecken.');
		$this->setLongDescription('Die Verbesserte Tarnung ist das Aktuellste, das die moderne Tarnforschung hervorgebracht hat.
			<br/>
			Jahrelang war die Wissenschaft damit beschäftigt, eine Lösung für das Problem zu finden, dass die bei der normalen Tarnung eingesetzte Lichtwellenumlenkung nur bei beweglichen Objekten wirksam ist. Ein mit der üblichen Tarnung ausgestattetes Gefährt ist im Stillstand sowohl für menschliche als auch elektronische Augen - wenn auch leicht verschwommen - sichtbar.
			<br/>
			Die Verbesserte Tarnung ergänzt die alte Tarnung um neueste Erkenntnisse auf dem Gebiet der Lumodynamik. So wird nicht nur die Umleitung der Lichtwellen signifikant verbessert, sondern insbesondere auch das Design der zu tarnenden Objekte leicht modifiziert um einen reibungsloseren Lichtwellenumfluss zu ermöglichen.
			<br/>
			Trotz der scheinbar gesteigerten Effizienz des Tarnfeldes hat auch diese Technologie leider ihre Schwächen: da für sich bewegende Objekte aufgrund von Ausstößen des Antriebs ein wesentlich größerer und sich ständig in der Form ändernder Bereich getarnt werden muss, wäre der Energieverbrauch bei Einsatz der Verbesserten Tarnung auf sich fortbewegende Fahrzeuge zu hoch um bewältigt werden zu können.
			<br/>
			Deshalb wird bei sich in Bewegung befindlichen Fahrzeugen weiterhin die alte Tarntechnologie eingesetzt, lediglich im Stillstand kann die Verbesserte Tarnung zum Einsatz kommen.
			<br/>
			Eine weitere Schwäche mit bislang ungeklärter Ursache ist, dass getarnte Objekte nach wie vor problemlos andere getarnte Objekte erkennen können. Somit kann die Verbesserte Tarnung nur dazu eingesetzt werden, Tarneinheiten vor feindlichen Spionagesonden unsichtbar zu machen - doch vor Tarnsonden gibt es leider nach wie vor keinen wirksamen Schutz.');
		$this->setPoints(50);
	}
}

?>