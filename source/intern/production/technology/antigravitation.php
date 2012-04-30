<?php

class Rakuun_Intern_Production_Technology_Antigravitation extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('antigravitation');
		$this->setName('Antigravitation');
		$this->setBaseIronCosts(2000);
		$this->setBaseBerylliumCosts(3000);
		$this->setBaseEnergyCosts(1000);
		$this->setBasePeopleCosts(1000);
		$this->setBaseTimeCosts(60*60);
		$this->addNeededBuilding('laboratory', 1);
		$this->addNeededBuilding('airport', 1);
		$this->setMaximumLevel(3);
		$this->setShortDescription('Der Antigravitationsantrieb wird für den Bau von Flugeinheiten benötigt.');
		$this->setLongDescription('Nur sehr wenig lassen Forscher über diese Technologie durchdringen.
			<br/>
			Grundsätzlich baut diese Technologie nicht auf der "normalen" Theorie der Gravitation, nach der jede Masse jede weitere anzieht (und die bisher noch nichteinmal die Anziehung begründet) auf, sondern auf der sogenannten Gravitationsdrucktheorie, laut der überall Teilchen rumschwirren, die eine Art Druck erzeugen und natürlich Körper zusammendrücken, da zwischen diesen durch ihre eigene Abschirmung weniger Gravitationsteilchen vorhanden sind und somit weniger Gravitationsdruck erzeugen.
			<br/>
			Die Anti-G Einheit erzeugt solche Teilchen um den Gleiter und ist somit vergleichbar mit der Reibungslosigkeit eines Hovercraft durch Luftausstoß.
			<br/>
			Die Erzeugung dieser Teilchen ist natürlich nicht leicht und benötigt ein fast perfektes Forschungslabor zur Entstehung.');
		$this->setPoints(10);
	}
}

?>