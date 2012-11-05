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
 * Checks if the meta owns 3 databases
 */
class Rakuun_Intern_Production_Requirement_Meta_GotDatabases extends Rakuun_Intern_Production_Requirement_Base {
	public function getDescription() {
		return 'Meta muss drei Datenbankteile besitzen';
	}
	
	public function fulfilled() {
		$options = array();
		$userSpecialsTable = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->getTable();
		$userTable = Rakuun_DB_Containers::getUserContainer()->getTable();
		$alliancesTable = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$metasTable = Rakuun_DB_Containers::getMetasContainer()->getTable();
		$options['join'] = array($userTable, $alliancesTable, $metasTable);
		$options['conditions'][] = array($userSpecialsTable.'.active = ?', true);
		$options['conditions'][] = array($userSpecialsTable.'.identifier IN ('.implode(', ', Rakuun_User_Specials_Database::getDatabaseIdentifiers()).')');
		$options['conditions'][] = array($userSpecialsTable.'.user = '.$userTable.'.id');
		$options['conditions'][] = array($userTable.'.alliance = '.$alliancesTable.'.id');
		$options['conditions'][] = array($alliancesTable.'.meta = '.$metasTable.'.id');
		$options['conditions'][] = array($metasTable.'.id = ?', $this->getProductionItem()->getOwner());
		return (Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->count($options) >= 3);
	}
}

?>