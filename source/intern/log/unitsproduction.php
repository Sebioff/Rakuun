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

class Rakuun_Intern_Log_UnitsProduction {
	public static function log(Rakuun_DB_User $user, $producedUnitInternalName, $producedAmount) {
		$options = array();
		$options['conditions'][] = array('user = ?', $user);
		$options['conditions'][] = array('time = ?', mktime(0, 0, 0));
		if (!($logEntry = Rakuun_DB_Containers::getLogUnitsProductionContainer()->selectFirst($options)))
			$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->time = mktime(0, 0, 0);
		$logEntry->{Text::underscoreToCamelCase($producedUnitInternalName)} += $producedAmount;
		Rakuun_DB_Containers::getLogUnitsProductionContainer()->save($logEntry);
	}
}

?>