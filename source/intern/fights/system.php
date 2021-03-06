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

class Rakuun_Intern_Fights_System {
	private $survivingAttackingUnitAmounts = array();
	private $survivingDefendingUnitAmounts = array();
	private $totalAttackingPower = 0;
	private $totalDefendingPower = 0;
	private $attackingPowerByUnits = 0;
	private $defendingPowerByUnits = 0;
	private $attackerUnitSource;
	private $defenderUnitSource;
	private $defenderWon = false;
	private $calculateForAlliedPlayers = false;
	
	public function __construct($calculateForAlliedPlayers = false) {
		$this->calculateForAlliedPlayers = $calculateForAlliedPlayers;
	}
	
	public function fight(DB_Record $attackerUnitSource, DB_Record $defenderUnitSource) {
		$att = $this->getAttackByUnitType($attackerUnitSource);
		$attTotal = $att['footsoldiers'] + $att['vehicles'] + $att['aircraft'];
		
		$deff = $this->getDefenseByUnitType($defenderUnitSource);
		$deffTotal = $deff['footsoldiers'] + $deff['vehicles'] + $deff['aircraft'] + $deff['stationary'];
		
		// calculate the armies fighting powers
		$attackingPowerByUnits = array();
		$totalAttackingPower = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($attackerUnitSource) as $attackingUnit) {
			if ($deffTotal > 0) {
				$attackingPowerByUnits[$attackingUnit->getInternalName()] = $attackingUnit->getAttackValueAgainst(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER) * $deff['footsoldiers'] / $deffTotal
				+ $attackingUnit->getAttackValueAgainst(Rakuun_Intern_Production_Unit::TYPE_VEHICLE) * $deff['vehicles'] / $deffTotal
				+ $attackingUnit->getAttackValueAgainst(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT) * $deff['aircraft'] / $deffTotal
				+ $attackingUnit->getAttackValueAgainst(Rakuun_Intern_Production_Unit::TYPE_STATIONARY) * $deff['stationary'] / $deffTotal;
			}
			else {
				$attackingPowerByUnits[$attackingUnit->getInternalName()] = $attackingUnit->getAttackValue();
			}
			$totalAttackingPower += $attackingPowerByUnits[$attackingUnit->getInternalName()];
		}
		
		
		$defendingPowerByUnits = array();
		$totalDefendingPower = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($defenderUnitSource) as $defendingUnit) {
			if ($defendingUnit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY) && $this->calculateForAlliedPlayers) {
				$defendingPowerByUnits[$defendingUnit->getInternalName()] = 0;
			}
			elseif ($attTotal > 0) {
				$defendingPowerByUnits[$defendingUnit->getInternalName()] = $defendingUnit->getDefenseValueAgainst(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER) * $att['footsoldiers'] / $attTotal
					+ $defendingUnit->getDefenseValueAgainst(Rakuun_Intern_Production_Unit::TYPE_VEHICLE) * $att['vehicles'] / $attTotal
					+ $defendingUnit->getDefenseValueAgainst(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT) * $att['aircraft'] / $attTotal;
			}
			else {
				$defendingPowerByUnits[$defendingUnit->getInternalName()] = $defendingUnit->getDefenseValue();
			}
			$totalDefendingPower += $defendingPowerByUnits[$defendingUnit->getInternalName()];
		}
		
		// aaand the winner iiiis.... (defender if $winningPower > 0, else attacker)
		// $winningPower is the amount of power that is used to determine how many units survive by distributing this power onto all available unit types
		$winningPower = $totalDefendingPower - $totalAttackingPower;
		
		if ($winningPower >= 0) {
			$winnerUnitSource = $defenderUnitSource;
			$winnerTotalPower = $totalDefendingPower;
			$winnerPowerByUnits = $defendingPowerByUnits;
			$loserUnitSource = $attackerUnitSource;
			$loserTotalPower = $totalAttackingPower;
			$loserPowerByUnits = $attackingPowerByUnits;
			$this->defenderWon = true;
		}
		else {
			$winnerUnitSource = $attackerUnitSource;
			$winnerTotalPower = $totalAttackingPower;
			$winnerPowerByUnits = $attackingPowerByUnits;
			$loserUnitSource = $defenderUnitSource;
			$loserTotalPower = $totalDefendingPower;
			$loserPowerByUnits = $defendingPowerByUnits;
			$this->defenderWon = false;
			$winningPower *= -1;
		}
		
		// add superiority bonus (0 - 5%)
		if ($loserTotalPower > 0)
			$superiority = $winnerTotalPower / $loserTotalPower;
		else
			$superiority = $winnerTotalPower;
		// map superiority onto numbers from -x to 5
		$superiority = min($superiority, 5);
		if ($superiority > 0) {
			// add bonus to winning power
			$winningPower += $winningPower / 100 * $superiority;
		}
		
		$fightingSequence = explode('|', $winnerUnitSource->fightingSequence);
		$survivingWinnerUnitAmounts = array();
		foreach ($fightingSequence as $fightingUnitName) {
			$fightingUnit = Rakuun_Intern_Production_Factory::getUnit($fightingUnitName, $winnerUnitSource);
			
			if (!$fightingUnit) {
				//FIXME: hack for pezettos in fighting sequence
				continue;
			}
			if ($fightingUnit->getAmount() <= 0)
				continue;
			
			if ($winningPower <= 0) {
				if ($this->calculateForAlliedPlayers)
					$survivingWinnerUnitAmounts[$fightingUnitName] = $fightingUnit->getAmount();
				else
					$survivingWinnerUnitAmounts[$fightingUnitName] = 0;
				continue;
			}
			
			// how much power does a single unit of this type have?
			$fightingPowerOfSingleUnit = $winnerPowerByUnits[$fightingUnitName] / $fightingUnit->getAmount();
			
			if ($fightingPowerOfSingleUnit <= 0)
				continue;
			
			// how many units of this type survive?
			$survivingAmount = round($winningPower / $fightingPowerOfSingleUnit);
			if ($survivingAmount > $fightingUnit->getAmount())
				$survivingAmount = $fightingUnit->getAmount();
			if ($fightingUnit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY) && $this->calculateForAlliedPlayers)
				$survivingAmount = $fightingUnit->getAmount();
			$survivingWinnerUnitAmounts[$fightingUnitName] = $survivingAmount;
			// reduce available power points by total power of all units of this type
			$winningPower -= $winnerPowerByUnits[$fightingUnitName];
		}
		
		$survivingLoserUnitAmounts = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($loserUnitSource) as $unit) {
			if ($unit->getAmount() > 0) {
				if ($unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY) && $this->calculateForAlliedPlayers)
					$survivingLoserUnitAmounts[$unit->getInternalName()] = $unit->getAmount();
				else
					$survivingLoserUnitAmounts[$unit->getInternalName()] = 0;
			}
		}
		
		if ($this->defenderWon) {
			$this->survivingDefendingUnitAmounts = $survivingWinnerUnitAmounts;
			$this->survivingAttackingUnitAmounts = $survivingLoserUnitAmounts;
		}
		else {
			$this->survivingDefendingUnitAmounts = $survivingLoserUnitAmounts;
			$this->survivingAttackingUnitAmounts = $survivingWinnerUnitAmounts;
		}
		
		$this->totalAttackingPower = $totalAttackingPower;
		$this->totalDefendingPower = $totalDefendingPower;
		$this->attackingPowerByUnits = $attackingPowerByUnits;
		$this->defendingPowerByUnits = $defendingPowerByUnits;
		$this->attackerUnitSource = $attackerUnitSource;
		$this->defenderUnitSource = $defenderUnitSource;
	}
	
	private function getAmountsByUnitType(DB_Record $unitSource) {
		$amounts = array();
		
		$amounts['footsoldiers'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER, $unitSource) as $unit) {
			$amounts['footsoldiers'] += $unit->getAmount();
		}
		$amounts['vehicles'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE, $unitSource) as $unit) {
			$amounts['vehicles'] += $unit->getAmount();
		}
		$amounts['aircraft'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT, $unitSource) as $unit) {
			$amounts['aircraft'] += $unit->getAmount();
		}
		$amounts['stationary'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY, $unitSource) as $unit) {
			$amounts['stationary'] += $unit->getAmount();
		}
		
		return $amounts;
	}
	
	private function getAttackByUnitType(DB_Record $unitSource) {
		$amounts = array();
		
		$amounts['footsoldiers'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER, $unitSource) as $unit) {
			$amounts['footsoldiers'] += $unit->getAttackValue();
		}
		$amounts['vehicles'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE, $unitSource) as $unit) {
			$amounts['vehicles'] += $unit->getAttackValue();
		}
		$amounts['aircraft'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT, $unitSource) as $unit) {
			$amounts['aircraft'] += $unit->getAttackValue();
		}
		
		return $amounts;
	}
	
	private function getDefenseByUnitType(DB_Record $unitSource) {
		$amounts = array();
		
		$amounts['footsoldiers'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER, $unitSource) as $unit) {
			$amounts['footsoldiers'] += $unit->getDefenseValue();
		}
		$amounts['vehicles'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE, $unitSource) as $unit) {
			$amounts['vehicles'] += $unit->getDefenseValue();
		}
		$amounts['aircraft'] = 0;
		foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT, $unitSource) as $unit) {
			$amounts['aircraft'] += $unit->getDefenseValue();
		}
		$amounts['stationary'] = 0;
		if (!$this->calculateForAlliedPlayers) {
			foreach (Rakuun_Intern_Production_Unit_Factory::getAllOfType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY, $unitSource) as $unit) {
				$amounts['stationary'] += $unit->getDefenseValue();
			}
		}
		
		return $amounts;
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getSurvivingAttackingUnitAmounts() {
		return $this->survivingAttackingUnitAmounts;
	}
	
	public function getSurvivingDefendingUnitAmounts() {
		return $this->survivingDefendingUnitAmounts;
	}
	
	public function getDefenderWon() {
		return $this->defenderWon;
	}
	
	public function getTotalAttackingPower() {
		return $this->totalAttackingPower;
	}
	
	public function getTotalDefendingPower() {
		return $this->totalDefendingPower;
	}
	
	public function getAttackingPowerByUnits() {
		return $this->attackingPowerByUnits;
	}
	
	public function getDefendingPowerByUnits() {
		return $this->defendingPowerByUnits;
	}
	
	public function getAttackerUnitSource() {
		return $this->attackerUnitSource;
	}
	
	public function getDefenderUnitSource() {
		return $this->defenderUnitSource;
	}
}

?>