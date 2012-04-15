<?php

class Rakuun_Intern_Production_Building_Berylliummine extends Rakuun_Intern_Production_Building_RessourceProducer {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('berylliummine');
		$this->setName('Berylliummine');
		$this->setBaseIronCosts(200);
		$this->setBaseBerylliumCosts(300);
		$this->setBasePeopleCosts(12);
		$this->setBaseTimeCosts(3*60);
		$this->setBaseBerylliumProduction(1);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Je weiter die Berylliummine ausgebaut ist und je mehr Arbeiter in ihr sind, desto mehr Beryllium liefert sie. Beryllium ist einer der beiden Grundrohstoffe, der für sämtliche Gebäude benötigt wird.');
		$this->setLongDescription('Die Berylliummine ist eine Mine, in der Beryllium gewonnen wird.
			<br/>
			Beryllium gehört zu den Erdalkalimetallen. Man findet es in der
			Erdkruste. Diese blaue Beryll-Varietät kommt in Pegmatiten und Graniten vor.
			<br/>
			Anwendungszwecke ergeben sich aus den nichtmagnetischen, nichtentzündlichen
			und leitenden Eigenschaften von Beryllium. Es findet breite Verwendung
			beim so genannten Multiplexverfahren. Bei hochreinen Miniaturbausteinen,
			die Beryllium enthalten, kann ein einzelner Draht hunderte von elektronischen
			Signalen übertragen.
			<br/>
			Obwohl Produkte aus Beryllium in Gebrauch und Umgang sicher sind, treten bei
			der Herstellung extrem giftiger Rauch und Staub auf. Es ist äußerste Vorsicht
			geboten, damit auch nicht geringste Mengen eingeatmet oder verschluckt werden.
			Die Arbeiter in den Berylliumminen leben sehr gefährlich und haben auch keine
			sehr hohe Lebenserwartung.
			<br/>
			Nach wie vor wird Beryllium außerdem für Flugzeugbauteile, Röntgenröhren
			und Gebäude eingesetzt.
			<br/>
			Beryllium gehört auch zu den grundlegenden Rohstoffen.');
		$this->setPoints(3);
	}
	
	protected function defineEffects() {
		$producedCurrentLevel = $this->getProducedBeryllium(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels()), $this->getLevel() + $this->getFutureLevels());
		$producedNextLevel = $this->getProducedBeryllium(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels() + 1), $this->getLevel() + $this->getFutureLevels() + 1);
		$this->addEffect('Erhöht die Menge des abgebauten Berylliums pro Minute um '.Text::formatNumber($producedNextLevel - $producedCurrentLevel));
	}
}

?>