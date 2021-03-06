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

class Rakuun_Intern_Event {
	const EVENT_TYPE_BUILDING_PRODUCE = 1;
	const EVENT_TYPE_BUILDING_REMOVE = 2;
	const EVENT_TYPE_BUILDING_DESTROY = 3;
	const EVENT_TYPE_TECHNOLOGY_PRODUCE = 4;
	const EVENT_TYPE_TECHNOLOGY_REMOVE = 5;
	const EVENT_TYPE_TECHNOLOGY_DESTROY = 6;
	
	public static function onChangeBuildingLevel(Rakuun_DB_Buildings $userBuildings, $internalName, $deltaLevel, Rakuun_DB_User $executingUser = null) {
		$record = new DB_Record();
		$record->user = $userBuildings->user;
		$record->time = time();
		$record->building = $internalName;
		$record->level = $userBuildings->{Text::underscoreToCamelCase($internalName)};
		$record->deltaLevel = $deltaLevel;
		if ($deltaLevel > 0) {
			$record->eventType = self::EVENT_TYPE_BUILDING_PRODUCE;
		}
		else {
			if ($executingUser->getPK() == $userBuildings->user->getPK())
				$record->eventType = self::EVENT_TYPE_BUILDING_REMOVE;
			else
				$record->eventType = self::EVENT_TYPE_BUILDING_DESTROY;
		}
		if ($executingUser)
			$record->executingUser = $executingUser;
		Rakuun_DB_Containers::getLogBuildingsContainer()->save($record);
		// if user is offline, save the news
		if ($record->eventType == self::EVENT_TYPE_BUILDING_PRODUCE && !$userBuildings->user->isOnline()) {
			$building = Rakuun_Intern_Production_Factory::getBuilding($internalName, $userBuildings->user);
			$userBuildings->user->news = $building->getName() . ' Stufe ' . $building->getLevel() . ' fertiggestellt.<br/>' . $userBuildings->user->news;
			Rakuun_User_Manager::update($userBuildings->user);
		}
		
		// award quests
		if (($record->eventType == self::EVENT_TYPE_BUILDING_PRODUCE)
			&& ($internalName == 'laboratory')
			&& ($record->level == Rakuun_Intern_Quest_FirstHighLaboratory::REQUIRED_LABORATORY_LEVEL)) {
				$quest = new Rakuun_Intern_Quest_FirstHighLaboratory();
				$quest->awardIfPossible($record->user);
		}
	}
	
	public static function onChangeTechnologyLevel(Rakuun_DB_Technologies $userTechnologies, $internalName, $deltaLevel, Rakuun_DB_User $executingUser = null) {
		$record = new DB_Record();
		$record->user = $userTechnologies->user;
		$record->time = time();
		$record->technology = $internalName;
		$record->level = $userTechnologies->{Text::underscoreToCamelCase($internalName)};
		$record->deltaLevel = $deltaLevel;
		if ($deltaLevel > 0) {
			$record->eventType = self::EVENT_TYPE_TECHNOLOGY_PRODUCE;
		}
		else {
			if ($executingUser->getPK() == $userTechnologies->user->getPK())
				$record->eventType = self::EVENT_TYPE_TECHNOLOGY_REMOVE;
			else
				$record->eventType = self::EVENT_TYPE_TECHNOLOGY_DESTROY;
		}
		// TODO save executing user (note: not neccessarily set)
		Rakuun_DB_Containers::getLogTechnologiesContainer()->save($record);
		// if user is offline, save the news
		if ($record->eventType == self::EVENT_TYPE_TECHNOLOGY_PRODUCE && !$userTechnologies->user->isOnline()) {
			$technology = Rakuun_Intern_Production_Factory::getTechnology($internalName, $userTechnologies->user);
			$userTechnologies->user->news = $technology->getName() . ' Stufe ' . $technology->getLevel() . ' fertiggestellt.<br/>' . $userTechnologies->user->news;
			Rakuun_User_Manager::update($userTechnologies->user);
		}
		
		// award quests
		if ($record->eventType == self::EVENT_TYPE_TECHNOLOGY_PRODUCE) {
			if ($internalName == 'momo') {
				$momo = Rakuun_Intern_Production_Factory::getTechnology('momo', $userTechnologies);
				if ($momo->getLevel() == $momo->getMaximumLevel()) {
					$quest = new Rakuun_Intern_Quest_FirstCompleteMomo();
					$quest->awardIfPossible($record->user);
				}
			}
		}
	}
	
	public static function getTextForEvent(DB_Record $event) {
		switch ($event->eventType) {
			case self::EVENT_TYPE_BUILDING_PRODUCE:
				$building = Rakuun_Intern_Production_Factory::getBuilding($event->building);
				return $building->getName().' Stufe '.$event->level.' fertiggestellt.';
			case self::EVENT_TYPE_BUILDING_REMOVE:
				$building = Rakuun_Intern_Production_Factory::getBuilding($event->building);
				return $building->getName().' Stufe '.($event->level + 1).' abgerissen.';
			case self::EVENT_TYPE_BUILDING_DESTROY:
				$building = Rakuun_Intern_Production_Factory::getBuilding($event->building);
				$label = new Rakuun_GUI_Control_UserLink('event_user_'.$event->getPK(), $event->executingUser, $event->get('executing_user'));
				return $building->getName().' Stufe '.($event->level + 1).' zerstört durch '.$label->render().'.';
			case self::EVENT_TYPE_TECHNOLOGY_PRODUCE:
				$technology = Rakuun_Intern_Production_Factory::getTechnology($event->technology);
				return $technology->getName().' Stufe '.$event->level.' fertiggestellt.';
			case self::EVENT_TYPE_TECHNOLOGY_REMOVE:
				$technology = Rakuun_Intern_Production_Factory::getTechnology($event->technology);
				return $technology->getName().' Stufe '.($event->level + 1).' abgerissen.';
		}
	}
}

?>