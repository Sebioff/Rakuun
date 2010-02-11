<?php

class Rakuun_Intern_Production_Building_Ironmine extends Rakuun_Intern_Production_Building_RessourceProducer {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('ironmine');
		$this->setName('Eisenmine');
		$this->setBaseIronCosts(300);
		$this->setBaseBerylliumCosts(200);
		$this->setBasePeopleCosts(12);
		$this->setBaseTimeCosts(6*60);
		$this->setBaseIronProduction(1);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Die Eisenmine liefert mehr Eisen, wenn sie ausgebaut wird und mehr Arbeiter in ihr sind. Eisen ist einer der beiden Grundrohstoffe, der für sämtliche Gebäude benötigt wird.');
		$this->setLongDescription('Die Eisenmine ist eine Mine, in der Eisen gewonnen wird.
			<br/>
			Eisen ist ein magnetisches, formbares silbrigweißes metallisches
			Element, welches für die Herstellung von Gebrauchsgegenständen, wie z.B.
			Werkzeuge oder für Ornamente verwendet wird.
			<br/>
			Dieses Element kann in verarbeiteter Form z. B. als Schmiedeeisen,
			Gusseisen oder Stahl verwendet werden.
			<br/>
			Es ist einer der grundlegenden Rohstoffe.');
		$this->setPoints(3);
	}
	
	protected function defineEffects() {
		$producedCurrentLevel = $this->getProducedIron(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels()), $this->getLevel() + $this->getFutureLevels());
		$producedNextLevel = $this->getProducedIron(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels() + 1), $this->getLevel() + $this->getFutureLevels() + 1);
		$this->addEffect('Erhöht die Menge des abgebauten Eisens pro Minute um '.GUI_Panel_Number::formatNumber($producedNextLevel - $producedCurrentLevel));
	}
}

?>