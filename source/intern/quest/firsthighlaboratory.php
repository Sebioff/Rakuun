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

class Rakuun_Intern_Quest_FirstHighLaboratory extends Rakuun_Intern_Quest {
	const REQUIRED_LABORATORY_LEVEL = 20;
	
	protected function awardTo(DB_Record $awardTo) {
		parent::awardTo($awardTo);
		
		if ($awardTo->technologies->enhancedCloaking < 1) {
			$awardTo->technologies->enhancedCloaking = 1;
			$awardTo->technologies->save();
		}
	}
	
	protected function canBeAwarded() {
		return (!$this->exists());
	}
	
	protected function getIdentifier() {
		return Rakuun_Intern_Quest::IDENTIFIER_FIRST_LABORATORY_10;
	}
	
	public function getDescription() {
		return 'Baue als Erster Forschungslabor Stufe '.self::REQUIRED_LABORATORY_LEVEL.'!';
	}
	
	public function getRewardDescription() {
		return 'Verbesserte Tarnung Stufe 1';
	}
	
	public function getOwnerName() {
		if ($owner = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->getRecord()->owner))
			return $owner->nameUncolored;
		else
			return Rakuun_DB_Containers::getUserDeletedContainer()->selectByIDFirst($this->getRecord()->owner)->nameUncolored;
	}
}

?>