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

class Rakuun_Intern_Production_Building_Store extends Rakuun_Intern_Production_Building {
	const SAVE_CAPACITY_RAISE_PER_WEEK = 2000;
	
	private $baseCapacity = 0;
	
	public function __construct($dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK, true);
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getCapacity($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return $level * $this->getBaseCapacity() * RAKUUN_STORE_CAPACITY_MULTIPLIER;
	}
	
	public function getSaveCapacity() {
		if ($this->getUser()->isYimtay())
			return 0;
		else
			return round(((time() - RAKUUN_ROUND_STARTTIME) * self::SAVE_CAPACITY_RAISE_PER_WEEK / 7 / 24 / 60 / 60 + self::SAVE_CAPACITY_RAISE_PER_WEEK) * RAKUUN_STORE_CAPACITY_SAVE_MULTIPLIER);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getBaseCapacity() {
		return $this->baseCapacity;
	}
	
	public function setBaseCapacity($baseCapacity) {
		$this->baseCapacity = $baseCapacity;
	}
}

?>