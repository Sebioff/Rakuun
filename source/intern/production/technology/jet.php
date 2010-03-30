<?php

class Rakuun_Intern_Production_Technology_Jet extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('jet');
		$this->setName('Düsenantrieb');
		$this->setBaseIronCosts(300);
		$this->setBaseBerylliumCosts(700);
		$this->setBaseEnergyCosts(600);
		$this->setBasePeopleCosts(80);
		$this->setBaseTimeCosts(720*60);
		$this->addNeededBuilding('laboratory', 9);
		$this->addNeededBuilding('airport', 1);
		$this->addNeededTechnology('engine', 5);
		$this->setMaximumLevel(3);
		$this->setShortDescription('Eine verbesserte Version der Standard-Antriebs-Form. Der Düsenantrieb ist absolut notwendig zur Produktion von Flugeinheiten.');
		$this->setLongDescription('Der Düsenantrieb ist für die Fortbewegung der Gleiter verantwortlich.
			<br/>
			Die Anti-G Einheit der Gleiter sorgt dafür, dass um sie herum keine Gravitation stattfindet und sie somit schwerelos einfach in der Luft hängen, allerdings ist es ihm nicht möglich, den Gleiter auch nur im entferntesten zu bewegen.
			<br/>
			Deshalb wird hier ein spezieller Düsenantrieb verwendet. Seine Hauptfunktionsweise besteht darin, durch speziell geformte, rotierende Blätter innerhalb der Düse Luft von vorne heranzusaugen und nach hinten abzustoßen, zusätzlich wird ein hochexplosiver Treibstoff im inneren entzündet und die Explosion kontrolliert nach hinten geleitet.');
		$this->setPoints(8);
	}
}

?>