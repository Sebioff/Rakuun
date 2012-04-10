<?php

class Rakuun_Intern_Production_Building_Laboratory extends Rakuun_Intern_Production_Building {
	const RESEARCH_TIME_REDUCTION_PERCENT = 5;
	const EXP_FOR_COSTS = 1.1;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laboratory');
		$this->setName('Forschungslabor');
		$this->setBaseIronCosts(600);
		$this->setBaseBerylliumCosts(300);
		$this->setBasePeopleCosts(30);
		$this->setBaseTimeCosts(20*60);
		$this->setMaximumLevel(19);
		$this->setShortDescription('Im Forschungslabor können neue Technologien, zum Beispiel zur Energiegewinnung oder für militärische Zwecke, erforscht werden.');
		$this->setLongDescription('Forschungslaboratorien erm&ouml;glichen mit ihren Ger&auml;tschaften eine zielgerichtete Forschung.
			<br/>
			Umso st&auml;rker das Forschungslabor ausgebaut wurde, umso bessere und gr&ouml;&szlig;ere Ger&auml;tschaften, die f&uuml;r schwierigere Forschungen oft unumg&auml;ngig sind, sind darin enthalten.
			<br/>
			Die Forscher sind die kl&uuml;gsten und kreativsten B&uuml;rger der Stadt und fr&ouml;nen mit Begeisterung ihrem Metier, oft arbeiten sie stundenlang unbezahlt im Labor, fasziniert von ihrer neusten Kreation.
			<br/>
			Nat&uuml;rlich ist man zwischen den Reagenzgl&auml;sern mit ihren &auml;tzenden und hochexlosiven Inhalten und den gigantischen Maschinen, die sich meistens auf eine winzige Fl&auml;che richten, nicht wirklich sicher, doch sind die Forscher sowieso von Natur aus ein eher vorsichtiger Schlag - wer auch nur einen kleinen Sicherheitsfehler macht, wird sofort fristlos entlassen.
			<br/>
			Bevor dann eine Technologie wirklich reif ist, vergehen oft zahllose Arbeitstunden des Testes und des Neubeginns.');
		$this->setPoints(2);
	}
	
	protected function defineEffects() {
		$this->addEffect('Verkürzung der Forschungszeiten um insgesamt '.(self::RESEARCH_TIME_REDUCTION_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
	
	//OVERRIDES
	public function getIronCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBaseIronCosts() * $level, EXP_FOR_COSTS));
	}
	
	public function getBerylliumCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBaseBerylliumCosts() * $level, EXP_FOR_COSTS));
	}
	
	public function getEnergyCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBaseEnergyCosts() * $level, EXP_FOR_COSTS));
	}
	
	public function getPeopleCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBasePeopleCosts() * $level, EXP_FOR_COSTS));
	}
}

?>