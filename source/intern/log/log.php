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

class Rakuun_Intern_Log {
	const MULTIPOINTS_LOGIN = 1;
	const MULTIPOINTS_REGISTRATION = 5;
	const MULTIPOINTS_RESSOURCES = 10;
	
	const ACTION_ACTIVITY_LOGIN = 0;
	const ACTION_ACTIVITY_LOGOUT = 1;
	const ACTION_ACTIVITY_REGISTRATION = 2;
	const ACTION_RESSOURCES_FIGHT = 3;
	const ACTION_RESSOURCES_ALLIANCE = 4;
	const ACTION_RESSOURCES_TRADE = 5;
	const ACTION_ACTIVITY_DELETE = 6;
	const ACTION_ACTIVITY_DELETE_INACTIVE = 7;
	const ACTION_ACTIVITY_LOCK_NOTACTIVATED = 8;
	const ACTION_USERDATA_EMAIL = 9;
	const ACTION_USERDATA_SITTER = 10;
	const ACTION_USERDATA_PASSWORD = 11;
	
	const MULTIACTION_SAME_IP = 0;
	const MULTIACTION_SAME_COOKIE = 1;
	
	const TYPE_TRANSFER_IN = 0;
	const TYPE_TRANSFER_OUT = 1;
	const TYPE_TRANSFER_FROM = 2;
	
	const IPWHOIS = 'http://www.ip-adress.com/whois/';
	
	protected static $multiPoints = array(
		self::ACTION_ACTIVITY_LOGIN => self::MULTIPOINTS_LOGIN,
		self::ACTION_ACTIVITY_LOGOUT => 0,
		self::ACTION_ACTIVITY_REGISTRATION => self::MULTIPOINTS_REGISTRATION,
		self::ACTION_RESSOURCES_FIGHT => self::MULTIPOINTS_RESSOURCES,
		self::ACTION_RESSOURCES_ALLIANCE => self::MULTIPOINTS_RESSOURCES,
		self::ACTION_RESSOURCES_TRADE => self::MULTIPOINTS_RESSOURCES,
		self::ACTION_ACTIVITY_DELETE => 0
	);
	
	protected static $actionDescriptions = array(
		self::ACTION_ACTIVITY_LOGIN => 'Login',
		self::ACTION_ACTIVITY_LOGOUT => 'Logout',
		self::ACTION_ACTIVITY_REGISTRATION => 'Anmeldung',
		self::ACTION_RESSOURCES_FIGHT => 'Kampf',
		self::ACTION_RESSOURCES_ALLIANCE => 'Allianzkasse',
		self::ACTION_RESSOURCES_TRADE => 'Handel',
		self::ACTION_ACTIVITY_DELETE => 'Account löschen',
		self::ACTION_ACTIVITY_DELETE_INACTIVE => 'Account löschen (inaktiv)',
		self::ACTION_ACTIVITY_LOCK_NOTACTIVATED => 'Account sperren (nicht aktiviert)',
		self::ACTION_USERDATA_EMAIL => 'neue Emailadresse',
		self::ACTION_USERDATA_PASSWORD => 'neues Passwort',
		self::ACTION_USERDATA_SITTER => 'neuen Sitter'
	);
	
	protected static $multiActionDescriptions = array(
		self::MULTIACTION_SAME_IP => 'IP',
		self::MULTIACTION_SAME_COOKIE => 'Cookie'
	);
	
	protected static $typeTransferDescriptions = array(
		self::TYPE_TRANSFER_IN => 'bekommen von',
		self::TYPE_TRANSFER_OUT => 'gesendet an',
		self::TYPE_TRANSFER_FROM => 'gesendet von'
	);
	
	public static function multiCheck(Rakuun_DB_User $user, $action) {
		if (!isset(self::$multiPoints[$action]) || self::$multiPoints[$action] === 0)
			return;
		
		// check for cookies
		if (isset($_COOKIE['data']) && $_COOKIE['data'] != $user->nameUncolored) {
			$multiUser = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($_COOKIE['data']);
			if ($multiUser) {
				$multiUser->multiPoints += self::$multiPoints[$action];
				$multiUser->save();
				
				$user->multiPoints += self::$multiPoints[$action];
				$user->save();
				
				DB_Connection::get()->beginTransaction();
				$multiactionLog = new DB_Record();
				$multiactionLog->action = $action;
				$multiactionLog->multiaction = self::MULTIACTION_SAME_COOKIE;
				$multiactionLog->time = time();
				Rakuun_DB_Containers::getLogMultiactionsContainer()->save($multiactionLog);
				$multiactionAssoc = new DB_Record();
				$multiactionAssoc->multiAction = $multiactionLog;
				$multiactionAssoc->user = $multiUser;
				Rakuun_DB_Containers::getLogMultiactionsUsersAssocContainer()->save($multiactionAssoc);
				$multiactionAssoc = new DB_Record();
				$multiactionAssoc->multiAction = $multiactionLog;
				$multiactionAssoc->user = $user;
				Rakuun_DB_Containers::getLogMultiactionsUsersAssocContainer()->save($multiactionAssoc);
				DB_Connection::get()->commit();
			}
		}
		
		// check for same ip
		$multiUsers = Rakuun_DB_Containers::getUserContainer()->selectByIP($_SERVER['REMOTE_ADDR']);
		if (count($multiUsers) > 1) {
			$multiactionLog = new DB_Record();
			$multiactionLog->action = $action;
			$multiactionLog->multiaction = self::MULTIACTION_SAME_IP;
			$multiactionLog->time = time();
			Rakuun_DB_Containers::getLogMultiactionsContainer()->save($multiactionLog);
			foreach ($multiUsers as $multiUser) {
				$multiUser->multiPoints += self::$multiPoints[$action];
				$multiUser->save();
				$multiactionAssoc = new DB_Record();
				$multiactionAssoc->multiAction = $multiactionLog;
				$multiactionAssoc->user = $multiUser;
				Rakuun_DB_Containers::getLogMultiactionsUsersAssocContainer()->save($multiactionAssoc);
			}
			$user->multiPoints += self::$multiPoints[$action];
		}
	}
	
	public static function getActionDescription($action) {
		return self::$actionDescriptions[$action];
	}
	
	public static function getMultiActionDescription($action) {
		return self::$multiActionDescriptions[$action];
	}
	
	public static function getTypeTransferDescription($action) {
		return self::$typeTransferDescriptions[$action];
	}
}

?>