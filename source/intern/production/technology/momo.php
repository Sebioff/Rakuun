<?php

class Rakuun_Intern_Production_Technology_Momo extends Rakuun_Intern_Production_Technology {
	const BUILDING_TIME_REDUCTION_PERCENT = 5;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('momo');
		$this->setName('MoMo');
		$this->setBaseIronCosts(1000);
		$this->setBaseBerylliumCosts(600);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(50);
		$this->setBaseTimeCosts(30*60);
		$this->addNeededBuilding('laboratory', 3);
		$this->setMaximumLevel(19);
		$this->setShortDescription('MoMo (Momentum Modularrecycling) nutzt eine komplizierte Technik, die eine Beschleunigung der Bauvorgänge ermöglicht.');
		$this->setLongDescription('Das Momentum Modularrecycling (MoMo) ist eine hochentwickelte Technologie, die den Bauprozess von Gebäuden deutlich beschleunigen kann.
			<br/>
			Der funktionale Kern dieser technischen Meisterleistung ist der Tempoglobulus-Generator, eine komplexe Vorrichtung zur Erzeugung einer großen Zeitblase, die, je nach Größe des Generators, ganze Gebäude umhüllen kann.
			<br/>
			Innerhalb dieser Blase läuft die Zeit deutlich schneller ab als außerhalb. Leider gilt dies nicht nur für Objekte oder Geschwindigkeiten, mit denen Arbeiten erledigt werden können, sondern auch für den Alterungsprozess der Personen, die sich im Wirkungsbereich der Zeitblase aufhalten. Deshalb werden nur einfache Arbeitsmannschaften hineingelassen, die regelmäßig ausgetauscht werden. Um raschem Schwund an akademischen Fachkräften vorzubeugen, werden in den Zeitblasen keine Forschungsarbeiten betrieben. Das Problem, dass Forschungen viel Zeit kosten und nicht effizient beschleunigbar sind, konnte noch nicht gelöst werden.
			<br/>
			Ein vollständiges Zurücksetzen der Zeit auf ein bereits vergangenes Datum ist bislang ebenfalls noch nicht gelungen.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Verkürzung der Bauzeit von Gebäuden um insgesamt '.(self::BUILDING_TIME_REDUCTION_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
}

?>