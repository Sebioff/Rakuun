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

class Rakuun_Intern_Production_Technology_Antigravitation extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('antigravitation');
		$this->setName('Antigravitation');
		$this->setBaseIronCosts(1600);
		$this->setBaseBerylliumCosts(240);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(800);
		$this->setBaseTimeCosts(48*60);
		$this->addNeededBuilding('laboratory', 1);
		$this->addNeededBuilding('airport', 1);
		$this->setMaximumLevel(3);
		$this->setShortDescription('Der Antigravitationsantrieb wird für den Bau von Flugeinheiten benötigt.');
		$this->setLongDescription('Nur sehr wenig lassen Forscher über diese Technologie durchdringen.
			<br/>
			Grundsätzlich baut diese Technologie nicht auf der "normalen" Theorie der Gravitation, nach der jede Masse jede weitere anzieht (und die bisher noch nichteinmal die Anziehung begründet) auf, sondern auf der sogenannten Gravitationsdrucktheorie, laut der überall Teilchen rumschwirren, die eine Art Druck erzeugen und natürlich Körper zusammendrücken, da zwischen diesen durch ihre eigene Abschirmung weniger Gravitationsteilchen vorhanden sind und somit weniger Gravitationsdruck erzeugen.
			<br/>
			Die Anti-G Einheit erzeugt solche Teilchen um den Gleiter und ist somit vergleichbar mit der Reibungslosigkeit eines Hovercraft durch Luftausstoß.
			<br/>
			Die Erzeugung dieser Teilchen ist natürlich nicht leicht und benötigt ein fast perfektes Forschungslabor zur Entstehung.');
		$this->setPoints(10);
	}
}

?>