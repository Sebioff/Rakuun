<?php

/**
 * FIXME finishing stuff of _offline_ users might be a problem.
 * E.g.: user is online, but not on overview/building page -> buildings don't get
 * finished. COULD be abused.
 */
class Rakuun_Cronjob_Script_Tick extends Cronjob_Script {
	public function execute() {
		// finish productions for not logged-in players ------------------------
		$options = array();
		$options['conditions'][] = array('is_online < ?', time() - Rakuun_Intern_Module::TIMEOUT_ISONLINE);
		foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $user) {
			if (!$user) {
				backtrace();
			}
			DB_Connection::get()->beginTransaction();
			// produce ressources (needs to be done first due to mines and stores)
			$user->produceRessources();
			// produce buildings
			new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getBuildingsContainer(), Rakuun_DB_Containers::getBuildingsWIPContainer(), $user);
			// produce technologies
			new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getTechnologiesContainer(), Rakuun_DB_Containers::getTechnologiesWIPContainer(), $user);
			// produce units
			new Rakuun_Intern_Production_Producer_Units(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers::getUnitsWIPContainer(), $user);
			// TODO quickfix: noob protection calculation isn't done everytime that is needed yet (e.g. the noob protection limits are raised)
			$user->recalculatePoints();
			DB_Connection::get()->commit();
		}
		
		// finish alliance buildings -------------------------------------------
		foreach (Rakuun_DB_Containers::getAlliancesContainer()->select() as $alliance) {
			DB_Connection::get()->beginTransaction();
			// produce buildings
			new Rakuun_Intern_Production_Producer_Alliances($alliance);
			DB_Connection::get()->commit();
		}
		
		// finish meta buildings -----------------------------------------------
		foreach (Rakuun_DB_Containers::getMetasContainer()->select() as $meta) {
			DB_Connection::get()->beginTransaction();
			// produce buildings
			new Rakuun_Intern_Production_Producer_Metas($meta);
			DB_Connection::get()->commit();
			
			if ($meta->dancertiaStarttime > 0 && $meta->dancertiaStarttime + RAKUUN_SPEED_DANCERTIA_STARTTIME < time() && !Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByRoundNameFirst(RAKUUN_ROUND_NAME))
				$this->onDancertiaStarted($meta);
		}
		
		// remove alliance diplomacies after notice-time -----------------------
		$options = array();
		$options['conditions'][] = array('status = ?', Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::STATUS_DELETED);
		$options['conditions'][] = array('(notice * 60 * 60) + date <= ?', time());
		Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->delete($options);
		
		// unban users ---------------------------------------------------------
		$this->unbanUsers();
	}
	
	private function onDancertiaStarted(Rakuun_DB_Meta $meta) {
		// TODO add IGM on game end
//		foreach (Rakuun_DB_Containers::getUserContainer()->select() as $user) {
//			// send IGM
//			$igm = new Rakuun_Intern_IGM('Ende der Runde', $user);
//			$igm->setSender(Rakuun_Intern_IGM::SENDER_SYSTEM);
//			$igm->setText('Glückwunsch an die Meta '.$meta->name.' zum Sieg der Runde!');
//			$igm->send();
//		}
		
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->beginTransaction();
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getAlliancesContainer(), Rakuun_DB_Containers_Persistent::getAlliancesContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getMetasContainer(), Rakuun_DB_Containers_Persistent::getMetasContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getUserContainer(), Rakuun_DB_Containers_Persistent::getUserContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getUserDeletedContainer(), Rakuun_DB_Containers_Persistent::getUserDeletedContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getBuildingsContainer(), Rakuun_DB_Containers_Persistent::getBuildingsContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getTechnologiesContainer(), Rakuun_DB_Containers_Persistent::getTechnologiesContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers_Persistent::getUnitsContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getLogUnitsProductionContainer(), Rakuun_DB_Containers_Persistent::getLogUnitsProductionContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getLogFightsContainer(), Rakuun_DB_Containers_Persistent::getLogFightsContainer());
		$this->copyContainerToPersistentDatabase(Rakuun_DB_Containers::getLogUserRessourcetransferContainer(), Rakuun_DB_Containers_Persistent::getLogUserRessourcetransferContainer());
		
		// save round information
		$record = new DB_Record();
		$record->roundName = RAKUUN_ROUND_NAME;
		$record->startTime = RAKUUN_ROUND_STARTTIME;
		$record->endTime = time();
		$record->winningMeta = $meta->name;
		Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->save($record);
		
		// finish building wips
		foreach (Rakuun_DB_Containers::getBuildingsWIPContainer()->select() as $wip) {
			$buildings = Rakuun_DB_Containers_Persistent::getBuildingsContainer()->selectByUserFirst($wip->user);
			$buildings->{Text::underscoreToCamelCase($wip->building)} += 1;
			$buildings->save();
		}
		
		// finish technology wips
		foreach (Rakuun_DB_Containers::getTechnologiesWIPContainer()->select() as $wip) {
			$technologies = Rakuun_DB_Containers_Persistent::getTechnologiesContainer()->selectByUserFirst($wip->user);
			$technologies->{Text::underscoreToCamelCase($wip->technology)} += 1;
			$technologies->save();
		}
		
		// finish unit wips
		foreach (Rakuun_DB_Containers::getUnitsWIPContainer()->select() as $wip) {
			$units = Rakuun_DB_Containers_Persistent::getUnitsContainer()->selectByUserFirst($wip->user);
			$units->{Text::underscoreToCamelCase($wip->unit)} += $wip->amount;
			$units->save();
		}
		
		// return fighting units home
		foreach (Rakuun_DB_Containers::getArmiesContainer()->select() as $army) {
			$units = Rakuun_DB_Containers_Persistent::getUnitsContainer()->selectByUserFirst($army->user);
			foreach (Rakuun_Intern_Production_Factory::getAllUnits($army) as $unit)
				$units->{Text::underscoreToCamelCase($unit->getInternalName())} += $unit->getAmount();
			$units->save();
		}
		
		// calculate user points
		foreach (Rakuun_DB_Containers_Persistent::getUserContainer()->select() as $user) {
			$user->points = 0;
			
			$buildings = Rakuun_DB_Containers_Persistent::getBuildingsContainer()->selectByUserFirst($user);
			foreach (Rakuun_Intern_Production_Factory::getAllBuildings($buildings) as $building) {
				$user->points += $building->getPoints() * $building->getLevel();
			}
			
			$technologies = Rakuun_DB_Containers_Persistent::getTechnologiesContainer()->selectByUserFirst($user);
			foreach (Rakuun_Intern_Production_Factory::getAllTechnologies($technologies) as $technology) {
				$user->points += $technology->getPoints() * $technology->getLevel();
			}
			
			$options = array();
			$properties = array();
			foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
				$properties[] = 'SUM('.$unit->getInternalName().') AS '.$unit->getInternalName();
			}
			$options['properties'] = implode(', ', $properties);
			$options['conditions'][] = array('user = ?', $user);
			$units = Rakuun_DB_Containers_Persistent::getLogUnitsProductionContainer()->selectFirst($options);
			foreach (Rakuun_Intern_Production_Factory::getAllUnits($units) as $unit) {
				$user->points += $unit->getPoints() * $unit->getAmount();
			}
			
			$user->save();
		}
		
		// calculate alliance points
		foreach (Rakuun_DB_Containers_Persistent::getAlliancesContainer()->select() as $alliance) {
			$alliance->points = 0;
			
			foreach (Rakuun_DB_Containers_Persistent::getUserContainer()->selectByAlliance($alliance) as $member) {
				$alliance->points += $member->points;
			}
			
			$alliance->save();
		}
		
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->commit();
	}
	
	private function copyContainerToPersistentDatabase(DB_Container $originalContainer, DB_Container $targetContainer) {
		if ($targetContainer->tableExists()) {
			$options = array();
			$options['order'] = 'ID DESC';
			$lastRoundName = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectFirst($options)->roundName;
			Rakuun_DB_Containers_Persistent::getPersistentConnection()->query('RENAME TABLE `'.$targetContainer->getTable().'` TO `'.Rakuun_DB_Containers_Persistent::roundNameToPrefix($lastRoundName).$targetContainer->getTable().'`');
		}
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->query('CREATE TABLE `'.$targetContainer->getTable().'` LIKE `'.DB_Connection::get()->getDatabaseName().'`.`'.$originalContainer->getTable().'`');
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->query('INSERT INTO `'.$targetContainer->getTable().'` SELECT * FROM `'.DB_Connection::get()->getDatabaseName().'`.`'.$originalContainer->getTable().'`');
	}
	
	private function unbanUsers() {
		$options = array();
		$options['conditions'][] = array('time < ?', time());
		$users = Rakuun_DB_Containers::getUserBannedContainer()->select($options);
		
		foreach ($users as $user) {
			Rakuun_User_Manager::unlock(Rakuun_DB_Containers::getUserContainer()->selectByPK($user->user));
			Rakuun_DB_Containers::getUserBannedContainer()->delete($user);
		}
	}
}

?>