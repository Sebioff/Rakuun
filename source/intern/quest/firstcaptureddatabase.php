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

class Rakuun_Intern_Quest_FirstCapturedDatabase extends Rakuun_Intern_Quest {
	const REWARD_IRON = 10000;
	const REWARD_BERYLLIUM = 10000;
	const REWARD_ENERGY = 2000;
	
	protected function awardTo(DB_Record $awardTo) {
		if ($awardTo->alliance) {
			parent::awardTo($awardTo->alliance);
			
			$awardTo->alliance->raise(self::REWARD_IRON, self::REWARD_BERYLLIUM, self::REWARD_ENERGY);
			
			// add alliance ressource log entry
			$log = new DB_Record();
			$log->alliance = $awardTo->alliance;
			$log->iron = self::REWARD_IRON;
			$log->beryllium = self::REWARD_BERYLLIUM;
			$log->energy = self::REWARD_ENERGY;
			$log->date = time();
			$log->type = Rakuun_Intern_GUI_Panel_Alliance_Account::TYPE_ALLIANCE_QUEST;
			Rakuun_DB_Containers::getAlliancesAccountlogContainer()->save($log);
		}
	}
	
	protected function canBeAwarded() {
		return (!$this->exists());
	}
	
	protected function getIdentifier() {
		return Rakuun_Intern_Quest::IDENTIFIER_FIRST_CAPTURED_DATABASE;
	}
	
	public function getDescription() {
		return 'Erobere als Erster ein Datenbankteil für deine Allianz!';
	}
	
	public function getRewardDescription() {
		return Text::formatNumber(self::REWARD_IRON).' Eisen, '.Text::formatNumber(self::REWARD_BERYLLIUM).' Beryllium und '.Text::formatNumber(self::REWARD_ENERGY).' Energie in die Allianzkasse';
	}
	
	public function getOwnerName() {
		if ($alliance = Rakuun_DB_Containers::getAlliancesContainer()->selectByPK($this->getRecord()->owner))
			return $alliance->name;
		else
			return 'gelöschte Allianz';
	}
}

?>