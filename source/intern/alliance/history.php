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

class Rakuun_Intern_Alliance_History {
	const TYPE_APPLICATION = 0;
	const TYPE_ACCEPTED = 1;
	const TYPE_UNACCEPTED = 2;
	const TYPE_KICK = 3;
	const TYPE_INVITATION = 4;
	const TYPE_LEAVE = 5;
	const TYPE_JOIN = 6;
	const TYPE_FOUND = 7;
	
	public function __construct(Rakuun_DB_User $user, $alliancename, $type) {
		$this->user = $user;
		$this->allianceName = $alliancename;
		$this->type = $type;
		$this->date = time();
	}
	
	public function save() {
		$record = new DB_Record();
		$record->user = $this->user;
		$record->allianceName = $this->allianceName;
		$record->type = $this->type;
		$record->date = $this->date;
		Rakuun_DB_Containers::getAllianceHistoryContainer()->save($record);
	}
	
	public static function getMessageTypes() {
		return array(
			self::TYPE_APPLICATION => 'Bewerbung',
			self::TYPE_ACCEPTED => 'Bewerbung angenommen',
			self::TYPE_UNACCEPTED => 'Bewerbung abgelehnt',
			self::TYPE_KICK => 'Rauswurf',
			self::TYPE_INVITATION => 'Einladung',
			self::TYPE_LEAVE => 'Austritt',
			self::TYPE_JOIN => 'Beitritt',
			self::TYPE_FOUND => 'Gründung'
		);
	}
}

?>