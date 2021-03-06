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

class Rakuun_Intern_Production_Technology_Cloaking extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('cloaking');
		$this->setName('Tarnung');
		$this->setBaseIronCosts(20000);
		$this->setBaseBerylliumCosts(20000);
		$this->setBaseEnergyCosts(20000);
		$this->setBasePeopleCosts(12000);
		$this->setBaseTimeCosts(6*24*60*60);
		$this->addNeededBuilding('laboratory', 15);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Die Tarnung ermöglicht den Bau getarnter Einheiten.');
		$this->setLongDescription('Die moderne Tarntechnologie setzt im Gegensatz zur alten nicht mehr ausschließlich Materialien ein, die Sonarwellen schlucken, sondern ist eine tatsächliche Unsichtbarwerdung.
			<br/>
			Der Hauptkniff dabei ist es, einen Körper im Äther (der Äther ist das Medium, in dem sich z.B. Licht und Magnetwellen in ihrer Form als Schwingung desselben befinden) quasi dynamisch zu machen, ähnlich wie ein Stromlinienkörper in der Luft dynamisch ist.
			<br/>
			Wie beim Stromlinienkörper die Luft einfach vorbeifliegt ohne dabei ihre Form zu ändern, so wird bei dieser Vorrichtung Licht einfach vorbeigeleitet.
			<br/>
			Natürlich ist die Technik nicht vollkommen ausgereift, so nehmen z.B. Personen einen getarnten Gleiter als Luftflimmern war.
			<br/>
			Eine unvorbereitete gegnerische Truppe mag so etwas wohl einfach übersehen, aber sobald sie wissen, dass der Gleiter dort ist (weil er z.B. auf sie schießt), können sie ihn dennoch schwach wahrnehmen und das Feuer erwidern.
			<br/>
			Der Tarngenerator wird meistens mit schalldämpfenden Stoffen und Anti-Sonar-Schichten verwendet um weitere verräterische Ausstrahlungen zu verhindern, dennoch gibt es einiges, wie z.B. Neutrinos, was durch das Feld kommt und von speziellen Sensoren aufgefangen werden kann.');
		$this->setPoints(50);
	}
}

?>