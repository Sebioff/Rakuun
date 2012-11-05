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

class Rakuun_Intern_Mode_BWSpeed extends Rakuun_Intern_Mode {
	public function onTick() {
		if (time() >= RAKUUN_ROUND_STARTTIME + 2 * 60 * 60 * 24 && !Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit')) {
			DB_Connection::get()->beginTransaction();
			foreach (Rakuun_DB_Containers::getUserContainer()->select() as $user) {
				$templateEngine = new GUI_TemplateEngine();
				$igm = new Rakuun_Intern_IGM('Kontinentalspaltung!', $user, $templateEngine->render(dirname(__FILE__).'/bwspeed_mail.tpl'));
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
				$igm->send();
			}
			
			foreach (Rakuun_DB_Containers::getAlliancesContainer()->select() as $alliance) {
				$alliance->delete();
			}
			
			// create alliance Black
			$allianceBlack = new Rakuun_DB_Alliance();
			$allianceBlack->name = 'Black';
			$allianceBlack->tag = 'B';
			Rakuun_DB_Containers::getAlliancesContainer()->save($allianceBlack);
			$options = array();
			$options['conditions'][] = array('city_x <= 58');
			// add leader rank to alliance
			$leaderRank = new DB_Record();
			$leaderRank->alliance = $allianceBlack;
			$leaderRank->name = 'Leiter';
			$leaderRank->groupIdentifier = Rakuun_Intern_Alliance_Security::GROUP_LEADERS;
			Rakuun_Intern_Alliance_Security::get()->getContainerGroups()->save($leaderRank);
			// add members to alliance
			$i = 0;
			foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $user) {
				$user->alliance = $allianceBlack;
				$user->nameColored = '[#000000]'.$user->nameUncolored.'[/#000000]';
				Rakuun_User_Manager::update($user);
				if ($i < 4)
					Rakuun_Intern_Alliance_Security::get()->addToGroup($user, $leaderRank);
				$i++;
			}
			$allianceBuildings = new DB_Record();
			$allianceBuildings->alliance = $allianceBlack;
			Rakuun_DB_Containers::getAlliancesBuildingsContainer()->save($allianceBuildings);
			
			// create alliance White
			$allianceWhite = new Rakuun_DB_Alliance();
			$allianceWhite->name = 'White';
			$allianceWhite->tag = 'W';
			Rakuun_DB_Containers::getAlliancesContainer()->save($allianceWhite);
			$options = array();
			$options['conditions'][] = array('city_x >= 64');
			// add leader rank to alliance
			$leaderRank = new DB_Record();
			$leaderRank->alliance = $allianceWhite;
			$leaderRank->name = 'Leiter';
			$leaderRank->groupIdentifier = Rakuun_Intern_Alliance_Security::GROUP_LEADERS;
			Rakuun_Intern_Alliance_Security::get()->getContainerGroups()->save($leaderRank);
			// add members to alliance
			$i = 0;
			foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $user) {
				$user->alliance = $allianceWhite;
				$user->nameColored = '[#EEEEEE]'.$user->nameUncolored.'[/#EEEEEE]';
				Rakuun_User_Manager::update($user);
				if ($i < 4)
					Rakuun_Intern_Alliance_Security::get()->addToGroup($user, $leaderRank);
				$i++;
			}
			$allianceBuildings = new DB_Record();
			$allianceBuildings->alliance = $allianceWhite;
			Rakuun_DB_Containers::getAlliancesBuildingsContainer()->save($allianceBuildings);
			
			$offer = new DB_Record();
			$offer->alliance_active = $allianceBlack;
			$offer->alliance_passive = $allianceWhite;
			$offer->text = 'Es kann nur einen Herrscher über Rakuun geben!';
			$offer->type = Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_WAR;
			$offer->notice = 24;
			$offer->status = Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::STATUS_ACTIVE;
			$offer->date = time();
			Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->save($offer);
			
			$record = new DB_Record();
			$record->key = 'bwspeed.hasBeenSplit';
			$record->value = 1;
			Rakuun_DB_Containers::getRegisterContainer()->save($record);
			
			DB_Connection::get()->commit();
		}
	}
	
	public function onNewUser(Rakuun_DB_User $user) {
		if (Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit')) {
			if ($user->cityX <= 58) {
				$alliance = Rakuun_DB_Containers::getAlliancesContainer()->selectByNameFirst('Black');
				$user->nameColored = '[#000000]'.$user->nameUncolored.'[/#000000]';
			}
			else {
				$alliance = Rakuun_DB_Containers::getAlliancesContainer()->selectByNameFirst('White');
				$user->nameColored = '[#EEEEEE]'.$user->nameUncolored.'[/#EEEEEE]';
			}
			$user->alliance = $alliance;
		}
	}
	
	/**
	 * @return Rakuun_Intern_Map_BWCoordinateGenerator
	 */
	public function getCoordinateGenerator() {
		return new Rakuun_Intern_Map_BWCoordinateGenerator();
	}
	
	public function getBitMapImage() {
		if (!Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit'))
			return imagecreatefrompng(PROJECT_PATH.'/www/images/map.png');
		else
			return imagecreatefrompng(PROJECT_PATH.'/www/images/map_bw.png');
	}
	
	public function getMapImagePath() {
		if (!Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit'))
			return Router::get()->getStaticRoute('images', 'map_large.png');
		else
			return Router::get()->getStaticRoute('images', 'map_large_bw.png');
	}
	
	public function allowFoundAlliances() {
		if (Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit'))
			return false;
		else
			return true;
	}
	
	public function allowLeaveAlliances() {
		if (Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit'))
			return false;
		else
			return true;
	}
	
	public function allowKickFromAlliances() {
		if (Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit'))
			return false;
		else
			return true;
	}
	
	public function allowDiplomacy() {
		if (Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit'))
			return false;
		else
			return true;
	}
	
	public function allowUserChangeNameColor() {
		if (Rakuun_DB_Containers::getRegisterContainer()->selectByKeyFirst('bwspeed.hasBeenSplit'))
			return false;
		else
			return true;
	}
}

?>