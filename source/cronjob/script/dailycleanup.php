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

class Rakuun_Cronjob_Script_DailyCleanup extends Cronjob_Script_FixedTime {
	public function execute() {
		// RESET ALLIANCE INVITATION COUNTER -----------------------------------
		$query = 'UPDATE alliances SET invitations = 0';
		DB_Connection::get()->query($query);
		
		// RESET USER'S STOCKMARKET TRADEVOLUME --------------------------------
		// TODO could easily be done without cronjob...
		$query = 'UPDATE users SET stockmarkettrade = 0, tradelimit = 0';
		DB_Connection::get()->query($query);
		
		// LITTLE CHEAT FOR STOCKMARKET PRICE DISPLAY --------------------------
		$options = array();
		$options['order'] = 'date DESC';
		$price = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		if ($price->date < strtotime('-1 day', mktime(12, 0, 0))) {
			$newPrice = new DB_Record();
			$newPrice->date = mktime(12, 0, 0);
			$newPrice->iron = $price->iron;
			$newPrice->beryllium = $price->beryllium;
			$newPrice->energy = $price->energy;
			Rakuun_DB_Containers::getStockmarketContainer()->save($newPrice);
		}
	}
}

?>