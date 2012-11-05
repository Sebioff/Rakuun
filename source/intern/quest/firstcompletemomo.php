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

class Rakuun_Intern_Quest_FirstCompleteMomo extends Rakuun_Intern_Quest {
	const BUILD_TIME_REDUCTION_PERCENT = 50;
	
	protected function canBeAwarded() {
		return (!$this->exists());
	}
	
	protected function getIdentifier() {
		return Rakuun_Intern_Quest::IDENTIFIER_FIRST_COMPLETE_MOMO;
	}
	
	public function getDescription() {
		return 'Erforsche als Erster den MoMo vollständig!';
	}
	
	public function getRewardDescription() {
		return self::BUILD_TIME_REDUCTION_PERCENT.'% Verkürzung der Bauzeit von Gebäuden';
	}
	
	public function getOwnerName() {
		if ($owner = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->getRecord()->owner))
			return $owner->nameUncolored;
		else
			return Rakuun_DB_Containers::getUserDeletedContainer()->selectByIDFirst($this->getRecord()->owner)->nameUncolored;
	}
}

?>