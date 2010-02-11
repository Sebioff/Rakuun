<?php

class Rakuun_Intern_Production_Technology_Antigravitation extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('antigravitation');
		$this->setName('Antigravitation');
		$this->setBaseIronCosts(3000);
		$this->setBaseBerylliumCosts(3500);
		$this->setBaseEnergyCosts(100);
		$this->setBaseTimeCosts(1080*60);
		$this->addNeededBuilding('laboratory', 7);
		$this->setMaximumLevel(2);
		$this->setShortDescription('Durch den Antigravitationsantrieb kannst du Flugeinheiten bauen.');
		$this->setLongDescription('Nur sehr wenig lassen Forscher über diese Technologie durchdringen.
			<br/>
			Grundsätzlich baut diese Technologie nicht auf der "normalen" Theorie der Gravitation, nach der jede Masse jede weitere anzieht und die bisher noch nichteinmal die Anziehung begründet auf, sondern auf der sogenannten Gravitationsdrucktheorie, laut der überall Teilchen rumschwirren, die eine Art Druck erzeugen und natürlich Körper zusammendrücken, da zwischen diesen durch ihre eigene Abschirmung weniger Gravitationsteilchen vorhanden sind und somit weniger Gravitationsdruck erzeugen.
			<br/>
			Die Anti-G Einheit erzeugt praktisch solche Teilchen um den Gleiter und ist somit vergleichbar mit der Reibungslosigkeit eines Hovercraft durch Luftausstoß.
			<br/>
			Die Erzeugung solcher Teilchen ist natürlich nicht wirklich leicht und benötigt ein fast perfektes Forschungslabor zur Entstehung.');
		$this->setPoints(9);
	}
}

?>