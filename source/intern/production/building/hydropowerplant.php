<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Intern_Production_Building_HydropowerPlant extends Rakuun_Intern_Production_Building_RessourceProducer {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('hydropower_plant');
		$this->setName('Wasserkraftwerk');
		$this->setBaseIronCosts(100);
		$this->setBaseBerylliumCosts(80);
		$this->setBasePeopleCosts(12);
		$this->setBaseTimeCosts(3*60);
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