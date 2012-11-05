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

class Rakuun_Intern_Production_Building_ShieldGenerator extends Rakuun_Intern_Production_Building {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('shield_generator');
		$this->setName('Schildgenerator');
		$this->setBaseIronCosts(40000);
		$this->setBaseBerylliumCosts(40000);
		$this->setBaseEnergyCosts(24000);
		$this->setBasePeopleCosts(4000);
		$this->setBaseTimeCosts(4*60*60);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_GotDatabases());
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_Meta_GotSpacePort());
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_Meta_GotNoDancertia());
		$this->setMaximumLevel(1);
		$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES, true);
		if (!isset($this->getUser()->alliance->meta) || $this->getUser()->alliance->meta->dancertia > 0)
			$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK, true);
		$this->setShortDescription('Der Schildgenerator erzeugt einen riesigen Schutzschild über dem Dancertia-Raumhafen der Meta-Allianz. Solange mindestens ein Generator in Betrieb ist, wird es für feindliche Angreifer unmöglich sein, dass dort im Bau befindliche Raumschiff, die "Dancertia", zu zerstören.<br/>Sobald sich die "Dancertia" im Bau befindet, können keine Schildgeneratoren mehr gebaut werden.');
		$this->setPoints(15);
	}
	
	public function canBuild() {
		return (parent::canBuild() && $this->getUser()->getDatabaseCount() >= 3);
	}
}

?>