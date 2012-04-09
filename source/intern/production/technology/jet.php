<?php

class Rakuun_Intern_Production_Technology_Jet extends Rakuun_Intern_Production_Technology {
	const SPEED_BONUS_PERCENT = 5;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('jet');
		$this->setName('Düsenantrieb');
		$this->setBaseIronCosts(25000);
		$this->setBaseBerylliumCosts(35000);
		$this->setBaseEnergyCosts(15000);
		$this->setBasePeopleCosts(15000);
		$this->setBaseTimeCosts(7*24*60*60 + 12*60*60); //7d 12h 00min
		$this->addNeededBuilding('laboratory', 9);
		$this->addNeededBuilding('airport', 1);
		$this->addNeededTechnology('engine', 5);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Eine verbesserte Version der Standard-Antriebs-Form. Der Düsenantrieb ist absolut notwendig zur Produktion von Flugeinheiten.');
		$this->setLongDescription('Der Düsenantrieb ist für die Fortbewegung der Gleiter verantwortlich.
			<br/>
			Die Anti-G Einheit der Gleiter sorgt dafür, dass um sie herum keine Gravitation stattfindet und sie somit schwerelos einfach in der Luft hängen, allerdings ist es ihm nicht möglich, den Gleiter auch nur im entferntesten zu bewegen.
			<br/>
			Deshalb wird hier ein spezieller Düsenantrieb verwendet. Seine Hauptfunktionsweise besteht darin, durch speziell geformte, rotierende Blätter innerhalb der Düse Luft von vorne heranzusaugen und nach hinten abzustoßen. Zusätzlich wird ein hochexplosiver Treibstoff im inneren entzündet und die Explosion kontrolliert nach hinten geleitet.');
		$this->setPoints(50);
	}
}

?>