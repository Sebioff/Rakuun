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
 * Base database class for building/technology records.
 * NOTE: can be used by user and alliance
 * FIXME "City" kinda doesn't make clear that it is used by alliances, change name
 */
class Rakuun_DB_CityItems extends DB_Record {
	/**
	 * Lowers the item level.
	 */
	public function lower($internalName, Rakuun_DB_User $destroyer, $deltaLevel = 1) {
		$escapedInternalName = DB_Container::escape($internalName);
		$databaseSchema = $this->getContainer()->getDatabaseSchema();
		$query = 'UPDATE '.$this->getContainer()->getTable().' SET
			`'.$escapedInternalName.'` = `'.$escapedInternalName.'` - '.$deltaLevel.'
			WHERE '.$databaseSchema['primaryKey'].' = '.$this->getPK();
		if ($this->getContainer()->update($query, $this) === true) {
			$this->{Text::underscoreToCamelCase($internalName)} -= $deltaLevel;
		}
	}
	
	/**
	 * Raises item level.
	 */
	public function raise($internalName, $deltaLevel = 1) {
		$escapedInternalName = DB_Container::escape($internalName);
		$databaseSchema = $this->getContainer()->getDatabaseSchema();
		$query = 'UPDATE '.$this->getContainer()->getTable().' SET
			`'.$escapedInternalName.'` = `'.$escapedInternalName.'` + '.$deltaLevel.'
			WHERE '.$databaseSchema['primaryKey'].' = '.$this->getPK();
		if ($this->getContainer()->update($query, $this) === true) {
			$this->{Text::underscoreToCamelCase($internalName)} += $deltaLevel;
		}
	}
}

?>