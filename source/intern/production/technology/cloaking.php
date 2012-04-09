<?php

class Rakuun_Intern_Production_Technology_Cloaking extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('cloaking');
		$this->setName('Tarnung');
		$this->setBaseIronCosts(25000);
		$this->setBaseBerylliumCosts(25000);
		$this->setBaseEnergyCosts(25000);
		$this->setBasePeopleCosts(10000);
		$this->setBaseTimeCosts(7*24*60*60 + 12*60*60); //7d 12h 00min
		$this->addNeededBuilding('laboratory', 8);
		$this->setMaximumLevel(3);
		$this->setShortDescription('Die Tarnung ermöglicht den Bau getarnter Einheiten.');
		$this->setLongDescription('Die moderne Tarntechnologie setzt im Gegensatz zur alten nicht mehr ausschließlich Materialien ein, die Sonarwellen schlucken, sondern ist eine tatsächliche Unsichtbarwerdung.
			<br/>
			Der Hauptkniff dabei ist es, einen Körper im Äther (der Äther ist das Medium, in dem sich z.B. Licht und Magnetwellen in ihrer Form als Schwingung desselben befinden) quasi dynamisch zu machen, ähnlich wie ein Stromlinienkörper in der Luft dynamisch ist.
			<br/>
			Wie beim Stromlinienkörper die Luft einfach vorbeifliegt ohne dabei ihre Form zu ändern, so wird bei dieser Vorrichtung Licht einfach vorbeigeleitet.
			<br/>
			Natürlich ist die Technik nicht vollkommen ausgereift, so nehmen z.B. Personen einen getarnten Gleiter als Luftflimmern war.
			<br/>
			Eine unvorbereitete gegnerische Truppe mag so etwas wohl einfach übersehen, aber sobald sie wissen, dass der Gleiter dort ist (weil er z.B. auf sie schießt), können sie ihn dennoch schwach wahrnehmen und das Feuer erwidern.
			<br/>
			Der Tarngenerator wird meistens mit schalldämpfenden Stoffen und Anti-Sonar-Schichten verwendet um weitere verräterische Ausstrahlungen zu verhindern, dennoch gibt es einiges, wie z.B. Neutrinos, was durch das Feld kommt und von speziellen Sensoren aufgefangen werden kann.');
		$this->setPoints(50);
	}
}

?>