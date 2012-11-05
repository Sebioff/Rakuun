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
 * @property Rakuun_DB_User $user
 * @property Rakuun_DB_User $target
 */
class Rakuun_DB_Army extends DB_Record {
	/**
	 * Makes the army calculate a path home
	 */
	public function moveHome() {
		Rakuun_DB_Containers::getArmiesPathsContainer()->deleteByArmy($this);
		$this->targetX = $this->user->cityX;
		$this->targetY = $this->user->cityY;
		$this->tick = time();
		$this->targetTime = 0;
		$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($this);
		$pathCalculator->getPath();
		$this->save();
	}
	
	public function canTransportDatabase() {
		$attackPower = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($this) as $unit) {
			$attackPower += $unit->getAttackValue();
			if ($attackPower >= 1000)
				return true;
		}
		return false;
	}
}

?>