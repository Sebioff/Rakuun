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

class Rakuun_Intern_Achievements_AdapterFactory {
	private static $instance = null;
	private $adapterList = array();
	
	private function __construct() {
		// Singleton
	}
	
	private function buildAdapterList() {
		$this->adapterList[] = new Rakuun_Intern_Achievements_Round24Adapter('24');
		$this->adapterList[] = new Rakuun_Intern_Achievements_Round25Adapter('25');
	}
	
	/**
	 * @return Rakuun_Intern_Achievements_Adapter
	 */
	public function getAdapterForRound($roundName) {
		if (!$this->adapterList)
			$this->buildAdapterList();
			
		$roundInformation = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByRoundNameFirst($roundName);
		
		foreach (array_reverse($this->adapterList) as $adapter) {
			$adapterRoundInformation = $adapter->getRoundInformation($adapter->getValidSinceRoundName());
			if ($adapterRoundInformation && $adapterRoundInformation->endTime <= $roundInformation->endTime)
				return $adapter;
		}
	}
	
	/**
	 * @return Rakuun_Intern_Achievements_AdapterFactory
	 */
	public static function get() {
		return (self::$instance) ? self::$instance : self::$instance = new self();
	}
}