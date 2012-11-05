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

/**
 * Panel to display the Alliance Highscore.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Highscore extends GUI_Panel_PageView {
	public function __construct($name, DB_Container $alliancesContainer, $title = '') {
		$options['order'] = 'points DESC';
		$alliances = $alliancesContainer->getFilteredContainer($options);
		parent::__construct($name, $alliances, $title);
		$this->setItemsPerPage(25);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/highscore.tpl');
		$this->addPanel($table = new GUI_Panel_Table('highscore'));
		$table->addHeader(array('Rang', 'Name', 'Meta', 'Mitglieder', 'Punkte', 'Durchschnitt'));
		$table->addTableCssClass('align_right', 3);
		$table->addTableCssClass('align_right', 4);
		$alliances = $this->getContainer()->select($this->getOptions());
		$i = 1 + (($this->getPage() - 1) * $this->getItemsPerPage());
		foreach ($alliances as $alliance) {
			$line = array();
			$line[] = $i;
			$line[] = new Rakuun_GUI_Control_AllianceLink('alliancelink'.$i, $alliance);
			$line[] = $alliance->meta ?
				new Rakuun_GUI_Control_MetaLink('alliancemetalink'.$i, $alliance->meta) :
				'';
			$line[] = new GUI_Panel_Number('alliancemembers'.$i, $alliance->memberscount);
			$line[] = new GUI_Panel_Number('alliancepoints'.$i, $alliance->points);
			$count = count($alliance->members);
			$allianceaverage = $alliance->points / ($count > 0 ? $count : 1);
			$number = new GUI_Panel_Number('allianceaverage'.$i, $allianceaverage);
			$number->setPrefix('&oslash; ');
			$line[] = $number;
			$table->addLine($line);
			$i++;
		}
		$table->setAttribute('summary', 'Allianzen Highscore');
	}
}
?>