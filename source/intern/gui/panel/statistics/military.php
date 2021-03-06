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

class Rakuun_Intern_GUI_Panel_Statistics_Military extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/military.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		$table->addTableCssClass('align_left', 0);
		$table->addHeader(array('Name', 'Wert'));
		
		$line = array('Laufende Angriffe:', Text::formatNumber(Rakuun_Intern_Statistics::noOfRunningAtts()));
		$table->addLine($line);
		
		$line = array('Bisher durchgeführte Angriffe:', Text::formatNumber(Rakuun_Intern_Statistics::noOfAtts()));
		$table->addLine($line);
		
		$propertiesUnits = array();
		$propertiesArmies = array();
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		foreach ($units as $unit) {
			$sumProperty = 'SUM('.$unit->getInternalName().') AS '.$unit->getInternalName().'_sum';
			$propertiesUnits[] = $sumProperty;
			if (!$unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY))
				$propertiesArmies[] = $sumProperty;
		}
		$options = array();
		$options['properties'] = implode(', ', $propertiesUnits);
		$unitAmounts = Rakuun_DB_Containers::getUnitsContainer()->selectFirst($options);
		$options = array();
		$options['properties'] = implode(', ', $propertiesArmies);
		$armyUnitAmounts = Rakuun_DB_Containers::getArmiesContainer()->selectFirst($options);
		foreach ($units as $unit) {
			$unitAmounts->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')} += $armyUnitAmounts->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')};
			$line = array($unit->getNameForAmount(2), Text::formatNumber($unitAmounts->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')}));
			$table->addLine($line);
		}
		
		$usersCount = Rakuun_Intern_Statistics::noOfPlayers();
		foreach ($units as $unit) {
			$line = array('&oslash; '.$unit->getNameForAmount(2).' / Spieler', Text::formatNumber(round($unitAmounts->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')} / $usersCount)));
			$table->addLine($line);
		}
	}

}

?>