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
 * Decorator for Rakuun_Intern_Production_Unit
 */
class Rakuun_Intern_Production_WIP_Unit extends Rakuun_Intern_Production_WIP {
	public function init() {
		parent::init();
		$this->cancel->setConfirmationMessage(
			'Wirklich abbrechen?\nEs werden 50% der Kosten erstattet:'.
			'\n'.Text::formatNumber(round($this->getWIPItem()->getIronRepayForAmount())).' Eisen'.
			'\n'.Text::formatNumber(round($this->getWIPItem()->getBerylliumRepayForAmount())).' Beryllium'.
			'\n'.Text::formatNumber(round($this->getWIPItem()->getEnergyRepayForAmount())).' Energie'.
			'\n'.Text::formatNumber(round($this->getWIPItem()->getPeopleRepayForAmount())).' Leute'
		);
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	/**
	 * @return int the number of finished units
	 */
	public function getAmountOfFinishedUnits() {
		return floor((time() - $this->getStartTime()) / $this->getWIPItem()->getTimeCosts(1));
	}
	
	/**
	 * @return int the time still needed to complete all units of this item
	 */
	public function getTotalRemainingTime() {
		return $this->getWIPItem()->getTimeCosts() - (time() - $this->getStartTime());
	}
	
	/**
	 * @return int the timestamp at which all units of this item will be completed
	 */
	public function getTotalTargetTime() {
		return $this->getWIPItem()->getTimeCosts() + $this->getStartTime();
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	/**
	 * @return int the time still needed to complete one unit of this item
	 */
	public function getRemainingTime() {
		return $this->getWIPItem()->getTimeCosts(1) - (time() - $this->getStartTime());
	}
	
	/**
	 * @return int the timestamp at which this the next unit of this item will be completed
	 */
	public function getTargetTime() {
		return $this->getWIPItem()->getTimeCosts(1) + $this->getStartTime();
	}
}

?>