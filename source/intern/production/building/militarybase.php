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

class Rakuun_Intern_Production_Building_MilitaryBase extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('military_base');
		$this->setName('Militärstützpunkt');
		$this->setBaseIronCosts(1200);
		$this->setBaseBerylliumCosts(1200);
		$this->setBaseEnergyCosts(1200);
		$this->setBasePeopleCosts(16);
		$this->setBaseTimeCosts(12*60);
		$this->setMaximumLevel(50);
		$this->setShortDescription('Der Militärstützpunkt ist sowohl Versammlungsort aller militärischen Einheiten, als auch der "Bauplatz" (und somit eine Grundvoraussetzung) für alle militärischen Gebäude.');
		$this->setLongDescription('Der Militärstützpunkt ist der Platz, auf dem alle militärischen Gebäude stehen.
			<br/>
			Er ist auch der Sammelpunkt für alle Boden- und Lufteinheiten.');
		$this->setPoints(10);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verkürzung der Produktionszeit von hier produzierten Einheiten um insgesamt '.$this->getProductionTimeReductionPercent($futureLevel + 1).'% (vorher: '.$this->getProductionTimeReductionPercent($futureLevel).'%)');
	}
	
	private function getProductionTimeReductionPercent($level) {
		return self::PRODUCTION_TIME_REDUCTION_PERCENT * $level;
	}
}

?>