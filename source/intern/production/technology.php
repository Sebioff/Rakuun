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

abstract class Rakuun_Intern_Production_Technology extends Rakuun_Intern_Production_CityItem {
	const INFLUENCE_ATTACK = 1; // binary 0001
	const INFLUENCE_DEFENSE = 2; // binary 0010
	
	private $influences = 0;
	
	public function __construct(DB_Record $dataSource = null) {
		$user = null;
		if (!$dataSource) {
			if ($user = Rakuun_User_Manager::getCurrentUser())
				$dataSource = $user->technologies;
		}
		elseif ($dataSource instanceof Rakuun_DB_User) {
			$user = $dataSource;
			$dataSource = $dataSource->technologies;
		}
		else {
			$user = $dataSource->user;
		}
		parent::__construct($dataSource, $user);
	}
	
	/**
	 * Returns the amount of levels that are currently being build.
	 */
	public function getFutureLevels() {
		$options = array();
		$options['conditions'][] = array('user = ?', $this->getUser());
		$options['conditions'][] = array('technology = ?', $this->getInternalName());
		return Rakuun_DB_Containers::getTechnologiesWIPContainer()->count($options);
	}
	
	/**
	 * Technologies can have certain influences. With this method it can be defined
	 * which influences belong to this technology.
	 * @param $influence see constants beginning with INFLUENCE_
	 */
	public function setInfluence($influence) {
		$this->influences |= $influence;
	}
	
	/**
	 * @return true if this technology has the given influence, false otherwise
	 */
	public function hasInfluence($influence) {
		return (($this->influences & $influence) == $influence);
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function getTimeCosts($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		$costs = $this->getBaseTimeCosts() * $level;
		$costs -= $costs / 100 * Rakuun_Intern_Production_Building_Laboratory::RESEARCH_TIME_REDUCTION_PERCENT * Rakuun_Intern_Production_Factory::getBuilding('laboratory', $this->getUser())->getLevel();
		$costs = round($costs / RAKUUN_SPEED_BUILDING);
		if ($costs < 1)
			$costs = 1;
		return $costs;
	}
}

?>