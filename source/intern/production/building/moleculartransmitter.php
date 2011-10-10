<?php

class Rakuun_Intern_Production_Building_Moleculartransmitter extends Rakuun_Intern_Production_Building {
	// receivable amount with one moleculartransmitter (multiplier in code)
	const TRADE_VOLUME = 1000;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('moleculartransmitter');
		$this->setName('Molekulartransmitter');
		$this->setBaseIronCosts(1000);
		$this->setBaseBerylliumCosts(1000);
		$this->setBasePeopleCosts(100);
		$this->setBaseTimeCosts(30*60);
		$this->addNeededBuilding('hydropower_plant', 5);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->setShortDescription('Der Molekulartransmitter ermöglicht es, auf einfachem Weg direkt mit anderen Rakuuranern zu handeln.');
		$this->setLongDescription('Der Molekulartransmitter kann eigentlich nicht richtig als Gebäude bezeichnet werden, sondern vielleicht eher als ein glaskugelähnliches Gebilde.
			<br/>
			Dieses hat aber dennoch eine wichtige Funktion im Zusammenleben der Rakuuraner, da es die Möglichkeit bietet, mit anderen Siedlungen zu handeln.
			<br/>
			Dabei wird zuerst die zu verschickende Ware auf eine etwas erhöhte Stelle in die Mitte der Kugel gelegt; danach wird, nachdem alle ihre Strahlenschutzanzüge angezogen haben, der Startknopf des Molekulartransmitters betätigt.
			<br/>
			Unter enormem Energieaufwand wird die Ware nun in ihre molekularen Bestandteile zerlegt und in Energiestrahlen eingeschlossen.
			<br/>
			Diese Energiestrahlen verstärken sich dann durch die reflektierende Wand bis auf das 10-fache und binden sich zu einem einzigen, sehr starken Energiestrahl zusammen, welcher nun über komplizierte Steuerungsmechanismen in den Planetenkern Rakuuns geschickt wird. Dort wird er dann zu der gewünschten Siedlung weitergeleitet, wo die Ware dann auf dem Rasen zwischen der Eisen- und Berylliummine wieder materialisiert und von den dortigen Arbeitern in die Lagerhallen gebracht wird.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Menge an erhaltbaren Ressourcen pro Tag um '.Text::formatNumber(self::TRADE_VOLUME * RAKUUN_TRADELIMIT_MULTIPLIER));
	}
}

?>