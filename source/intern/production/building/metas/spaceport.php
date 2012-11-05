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

class Rakuun_Intern_Production_Building_Metas_SpacePort extends Rakuun_Intern_Production_MetaBuilding {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('space_port');
		$this->setName('Dancertia-Raumhafen');
		$this->setBaseIronCosts(200000);
		$this->setBaseBerylliumCosts(200000);
		$this->setBaseEnergyCosts(100000);
		$this->setBasePeopleCosts(20000);
		$this->setBaseTimeCosts(36*60*60);
		$this->setMaximumLevel(1);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_Meta_GotDatabases());
		$this->setShortDescription('Der Dancertia-Raumhafen wird für den Bau der Dancertia benötigt. Sobald der Raumhafen fertiggestellt ist,<br/> können die Mitglieder der Meta Schildgeneratoren bauen, welche den Raumhafen vor Angreifern schützen.');
	}
}

?>