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

class Rakuun_Intern_Production_Technology_LightPlating extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('light_plating');
		$this->setName('Leichte Panzerung');
		$this->setBaseIronCosts(1600);
		$this->setBaseBerylliumCosts(1600);
		$this->setBaseEnergyCosts(1600);
		$this->setBasePeopleCosts(800);
		$this->setBaseTimeCosts(48*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_DEFENSE);
		$this->addNeededBuilding('laboratory', 1);
		$this->addNeededBuilding('tank_factory', 1);
		$this->setMaximumLevel(3);
		$this->setShortDescription('Zur Produktion leicht gepanzerter Einheiten.');
		$this->setLongDescription('Die leichte Panzerung setzt auf einen eher leichten Schutz, der eine hohe Beweglichkeit erlaubt, sodass die damit ausgerüsteten Einheiten den Angriffen komplett ausweichen können, anstatt einfach den Schuss zu absorbieren.
			<br/>
			Meist wird eine einfache, stabile Schicht aus komprimiertem Kohlenstoff verwendet, die durch ihre enorme Leichtigkeit kaum Gewicht hat und trotz der Stabilität biegsam ist.');
		$this->setPoints(10);
	}
}

?>