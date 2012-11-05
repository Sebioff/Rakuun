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

class Rakuun_Intern_GUI_Panel_Statistics extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/statistics.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		$table->addTableCssClass('align_left', 0);
		$table->addHeader(array('Name', 'Wert'));
		
		$line = array('Anzahl Spieler:', Text::formatNumber(Rakuun_Intern_Statistics::noOfPlayers()));
		$table->addLine($line);
		
		$line = array('Anzahl inaktiver Spieler:', Text::formatNumber(Rakuun_Intern_Statistics::noOfInactiveUsers()));
		$table->addLine($line);
		
		$line = array('Anzahl eingeloggter Spieler:', Text::formatNumber(Rakuun_Intern_Statistics::noOfLoggedInUsers()));
		$table->addLine($line);
		
		$line = array('Noobschutz Punktegrenze:', Text::formatNumber(Rakuun_Intern_Statistics::getNoobPointLimit()));
		$table->addLine($line);
		
		// calc armystrength
		$line = array('Noobschutz Armeestärkegrenze:', Text::formatNumber(Rakuun_Intern_Statistics::getNoobArmyStrengthLimit()));
		$table->addLine($line);
		
		$line = array('Anzahl Allianzen:', Text::formatNumber(Rakuun_Intern_Statistics::noOfAllies()));
		$table->addLine($line);
		
		$line = array('Anzahl Metas:', Text::formatNumber(Rakuun_Intern_Statistics::noOfMetas()));
		$table->addLine($line);
		
		$line = array('Vergebene Verwarnungspunkte:', Text::formatNumber(Rakuun_Intern_Statistics::noOfCautionPoints()));
		$table->addLine($line);
		
		$line = array('Anzahl verwarnter User:', Text::formatNumber(Rakuun_Intern_Statistics::noOfCautionedUsers()));
		$table->addLine($line);
	}

}

?>