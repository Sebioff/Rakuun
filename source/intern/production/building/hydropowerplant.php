<?php

class Rakuun_Intern_Production_Building_HydropowerPlant extends Rakuun_Intern_Production_Building_RessourceProducer {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('hydropower_plant');
		$this->setName('Wasserkraftwerk');
		$this->setBaseIronCosts(125);
		$this->setBaseBerylliumCosts(100);
		$this->setBasePeopleCosts(15);
		$this->setBaseTimeCosts(5*60);
		$this->addNeededTechnology('hydropower', 1);
		$this->setBaseEnergyProduction(1);
		$this->setShortDescription('Liefert Energie.');
		$this->setLongDescription('Wasserkraftwerk nutzen die Bewegung des Wassers, um Energie zu erzeugen.
			<br/>
			Da das Wasser wenig in der Menge variiert, ist der Stromgewinn durch das Wasser relativ konstant und kann zu allen Tageszeiten und bei jedem Wetter genutzt werden.
			<br/>
			Ein Wasserkraftwerk ist im Normallfall in einem Damm eingebaut; durch den Vorrat im Stausee ist auch während Trockenperioden Energiegewinnung garantiert. Der Druck des Sees drückt das Wasser unvorstellbar stark durch enge Röhren, in denen Turbinen sitzen, welche durch das Wasser angetrieben werden und einen Dynamo antreiben, der dadurch Strom produziert.');
		$this->setPoints(3);
	}
	
	protected function defineEffects() {
		$producedCurrentLevel = $this->getProducedEnergy(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels()), $this->getLevel() + $this->getFutureLevels());
		$producedNextLevel = $this->getProducedEnergy(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels() + 1), $this->getLevel() + $this->getFutureLevels() + 1);
		$this->addEffect('Erhöht die Menge der erzeugten Energie pro Minute um '.Text::formatNumber($producedNextLevel - $producedCurrentLevel));
	}
}

?>