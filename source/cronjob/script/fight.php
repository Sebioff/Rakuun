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

class Rakuun_Cronjob_Script_Fight extends Cronjob_Script {
	/** the maximum reachable probability that a building is destructed */
	const DESTRUCTION_MAX_PROBABILITY = 75;
	/** the needed attack force to reach DESTRUCTION_MAX_PROBABILITY */
	const DESTRUCTION_NEEDED_FORCE_FOR_MAX = 2000;
	
	public function execute() {
		$options = array();
		$options['order'] = 'target_time ASC, ID ASC';
		foreach (Rakuun_DB_Containers::getArmiesContainer()->select($options) as $army) {
			DB_Connection::get()->beginTransaction();
			
			$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
			$path = $pathCalculator->getPath();
			if (count($path) <= 1) {
				// army reached enemy city target
				if ($army->target && $army->targetX == $army->target->cityX && $army->targetY == $army->target->cityY) {
					if ($army->spydrone > 0 || $army->cloakedSpydrone > 0)
						$this->spy($army);
					else
						$this->fight($army);
				}
				// army returns home
				else if ($army->targetX == $army->user->cityX && $army->targetY == $army->user->cityY) {
					$this->returnHome($army);
				}
				// army reached some target anywhere on the map
				else {
					// check if there's a free database
					if ($army->user->alliance && $army->canTransportDatabase()) {
						$visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance($army->user->alliance);
						if (!empty($visibleDatabases)) {
							$options = array();
							$options['conditions'][] = array('position_x = ?', $army->targetX);
							$options['conditions'][] = array('position_y = ?', $army->targetY);
							$options['conditions'][] = array('identifier IN ('.implode(', ', $visibleDatabases).')');
							if ($database = Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->selectFirst($options)) {
								$databaseSpecial = new Rakuun_User_Specials_Database($army->user, $database->identifier, true);
								$databaseSpecial->giveSpecial();
								$database->delete();
								
								// award quest
								$quest = new Rakuun_Intern_Quest_FirstCapturedDatabase();
								$quest->awardIfPossible($army->user);
							}
						}
					}
					
					// make army return home
					$army->moveHome();
				}
			}
			DB_Connection::get()->commit();
		}
	}
	
	private function fight(Rakuun_DB_Army $army) {
		$playersAreAllied =	($army->user->alliance && $army->target->alliance && $army->user->alliance->getPK() == $army->target->alliance->getPK());
		if (!$playersAreAllied && $army->user->alliance && $army->target->alliance && $diplomacy = $army->user->alliance->getDiplomacy($army->target->alliance)) {
			$playersAreAllied = ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_AUVB);
		}
		
		$fightingSystem = new Rakuun_Intern_Fights_System($playersAreAllied);
		$fightingSystem->fight($army, $army->target->units);
		
		$userAllianceLink = '';
		$targetAllianceLink = '';
		if ($army->user->alliance) {
			$link = new Rakuun_GUI_Control_AllianceLink('alliance_link', $army->user->alliance);
			$link->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			$userAllianceLink = $link->render();
		}
		if ($army->target->alliance) {
			$link = new Rakuun_GUI_Control_AllianceLink('alliance_link', $army->target->alliance);
			$link->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			$targetAllianceLink = $link->render();
		}
		$defenderReportMarkers = array();
		$attackerReportMarkers = array();
		$link = new Rakuun_GUI_Control_UserLink('user_link', $army->user);
		$userLink = $link->render();
		$link = new Rakuun_GUI_Control_UserLink('target_link', $army->target);
		$targetLink = $link->render();
		
		if ($fightingSystem->getDefenderWon()) {
			$options = array();
			$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
			$winnerUnitSource = Rakuun_DB_Containers::getUnitsContainer()->selectByUserFirst($army->target, $options);
			$loserUnitSource = $army;
			$survivingWinnerUnitAmounts = $fightingSystem->getSurvivingDefendingUnitAmounts();
			$survivingLoserUnitAmounts = $fightingSystem->getSurvivingAttackingUnitAmounts();
			$defenderReportText = 'Wir wurden angegriffen!<br/>Eine feindliche Armee von '.$userLink.$userAllianceLink.' versuchte unsere Stadt zu überfallen, doch wir konnten den Feind erfolgreich abwehren.';
			$attackerReportText = 'Einer Ihrer Angriffe war eine Niederlage!<br/>Beim Überfall auf '.$targetLink.$targetAllianceLink.' wurde unsere Armee vernichtend geschlagen.';
			$defenderReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_WON;
			$attackerReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_LOST;
		}
		else {
			$winnerUnitSource = $army;
			$options = array();
			$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
			$loserUnitSource = Rakuun_DB_Containers::getUnitsContainer()->selectByUserFirst($army->target, $options);
			$survivingWinnerUnitAmounts = $fightingSystem->getSurvivingAttackingUnitAmounts();
			$survivingLoserUnitAmounts = $fightingSystem->getSurvivingDefendingUnitAmounts();
			$defenderReportText = 'Wir wurden angegriffen!<br/>Eine feindliche Armee von '.$userLink.$userAllianceLink.' überfiel unsere Stadt und vernichtete unsere Armee.';
			$attackerReportText = 'Einer Ihrer Angriffe war ein Erfolg!<br/>Beim Überfall auf '.$targetLink.$targetAllianceLink.' wurde die gegnerische Armee vernichtend geschlagen.';
			$defenderReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_LOST;
			$attackerReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_WON;
		}
			
		// WINNER --------------------------------------------------------------
		// report for winner
		$winnerReportText = '<br/><br/>Folgende Verluste sind zu beklagen:';
		$deadWinnerUnitsTextForWinner = '';
		$deadWinnerUnitsTextForLoser = '';
		$winnerLostUnits = array();
		foreach ($survivingWinnerUnitAmounts as $unitName => $unitAmount) {
			$unit = Rakuun_Intern_Production_Factory::getUnit($unitName, $winnerUnitSource);
			$deadUnitAmount = $unit->getAmount() - $unitAmount;
			if ($deadUnitAmount > 0) {
				$deadWinnerUnitsTextForWinner .= '<br/>'.Text::formatNumber($deadUnitAmount).'/'.Text::formatNumber($unit->getAmount()).' '.$unit->getNameForAmount();
				$deadWinnerUnitsTextForLoser .= '<br/>'.Text::formatNumber($deadUnitAmount).'/'.Text::formatNumber($unit->getAmount()).' '.$unit->getNameForAmount();
				// delete winner units
				$winnerUnitSource->{Text::underscoreToCamelCase($unitName)} -= $deadUnitAmount;
				$winnerLostUnits[$unitName] = $deadUnitAmount;
			}
			elseif ($unit->getAmount() > 0) {
				$deadWinnerUnitsTextForWinner .= '<br/>0/'.Text::formatNumber($unit->getAmount()).' '.$unit->getNameForAmount();
			}
		}
		$winnerUnitSource->save();
		$winnerReportText .= $deadWinnerUnitsTextForWinner;
		
		$deadLoserUnitsText = '';
		$loserLostUnits = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($loserUnitSource) as $unit) {
			if ($unit->getAmount() > 0 && !$unit->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK)) {
				$deadUnitAmount = $unit->getAmount();
				if (isset($survivingLoserUnitAmounts[$unit->getInternalName()]))
					$deadUnitAmount = $unit->getAmount() - $survivingLoserUnitAmounts[$unit->getInternalName()];
				if ($deadUnitAmount > 0) {
					$deadLoserUnitsText .= '<br/>'.Text::formatNumber($deadUnitAmount).' '.$unit->getNameForAmount($deadUnitAmount);
					// delete loser units
					$loserUnitSource->{Text::underscoreToCamelCase($unit->getInternalName())} -= $deadUnitAmount;
					$loserLostUnits[$unit->getInternalName()] = $deadUnitAmount;
				}
			}
		}
		$loserUnitSource->save();
		if ($deadLoserUnitsText)
			$winnerReportText .= '<br/><br/>Die gegnerische Armee wurde vollständig vernichtet:'.$deadLoserUnitsText;
		else
			$winnerReportText .= '<br/><br/>Es wurden keine gegnerischen Einheiten vernichtet.';
			
		Rakuun_Intern_Log_Fights::log($winnerUnitSource->user, $loserUnitSource->user, $army->user, $winnerLostUnits, $loserLostUnits, $army->getPK());
			
		// LOSER ---------------------------------------------------------------
		//report for loser
		if (!$deadLoserUnitsText)
			$deadLoserUnitsText = '<br/>Keine.';
		$loserReportText = '<br/><br/>Folgende Verluste sind zu beklagen:'.$deadLoserUnitsText;
		if ($deadWinnerUnitsTextForLoser) {
			$loserReportText .= '<br/><br/>Der gegnerischen Armee konnte folgender Schaden zugefügt werden:'.$deadWinnerUnitsTextForLoser;
			$loserReportText .= '<br/>Möglicherweise besaß der Gegner sogar weitere Einheiten, die von unseren Truppen nicht einmal entdeckt werden konnten.';
		}
		else {
			$loserReportText .= '<br/><br/>Es wurden keine gegnerischen Einheiten vernichtet.';
		}
		
		if ($fightingSystem->getDefenderWon()) {
			$defenderReportText .= $winnerReportText;
			$attackerReportText .= $loserReportText;
			
			if (!empty($winnerLostUnits))
				$defenderReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_LOSTUNITS;
			if (!empty($loserLostUnits))
				$attackerReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_LOSTUNITS;
			
			// delete attacking army
			$army->delete();
		}
		else {
			if (!empty($loserLostUnits))
				$defenderReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_LOSTUNITS;
			if (!empty($winnerLostUnits))
				$attackerReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_LOSTUNITS;
			
			// make army return home
			$army->moveHome();
			
			// STEALING RESSOURCES ---------------------------------------------
			if (!$playersAreAllied) {
				$totalCapacity = 0;
				foreach (Rakuun_Intern_Production_Factory::getAllUnits($army) as $unit) {
					$totalCapacity += $unit->getRessourceTransportCapacity();
				}

				$options = array();
				$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
				$targetRessources = Rakuun_DB_Containers::getRessourcesContainer()->selectByUserFirst($army->target, $options);
				
				$takeableIron = $targetRessources->iron - $targetRessources->getSaveCapacityIron();
				if ($takeableIron < 0)
					$takeableIron = 0;
				$takeableBeryllium = $targetRessources->beryllium - $targetRessources->getSaveCapacityBeryllium();
				if ($takeableBeryllium < 0)
					$takeableBeryllium = 0;
				$takeableEnergy = $targetRessources->energy - $targetRessources->getSaveCapacityEnergy();
				if ($takeableEnergy < 0)
					$takeableEnergy = 0;
					
				$remainingCapacity = $totalCapacity;
				$stolenIron = 0;
				$stolenBeryllium = 0;
				$stolenEnergy = 0;
				while ($remainingCapacity > 0 &&
					($stolenIron < $takeableIron || $stolenBeryllium < $takeableBeryllium || $stolenEnergy < $takeableEnergy)
				) {
					$totalPriority = 0;
					if ($stolenIron < $takeableIron)
						$totalPriority += $army->ironPriority;
					if ($stolenBeryllium < $takeableBeryllium)
						$totalPriority += $army->berylliumPriority;
					if ($stolenEnergy < $takeableEnergy)
						$totalPriority += $army->energyPriority;
					$maxIronCapacity = $remainingCapacity * $army->ironPriority / $totalPriority;
					$maxBerylliumCapacity = $remainingCapacity * $army->berylliumPriority / $totalPriority;
					$maxEnergyCapacity = $remainingCapacity * $army->energyPriority / $totalPriority;
					if ($stolenIron + $maxIronCapacity > $takeableIron)
						$maxIronCapacity = $takeableIron - $stolenIron;
					if ($stolenBeryllium + $maxBerylliumCapacity > $takeableBeryllium)
						$maxBerylliumCapacity = $takeableBeryllium - $stolenBeryllium;
					if ($stolenEnergy + $maxEnergyCapacity > $takeableEnergy)
						$maxEnergyCapacity = $takeableEnergy - $stolenEnergy;
						
					$stolenIron += $maxIronCapacity;
					$stolenBeryllium += $maxBerylliumCapacity;
					$stolenEnergy += $maxEnergyCapacity;
					$remainingCapacity -= $maxIronCapacity + $maxBerylliumCapacity + $maxEnergyCapacity;
				}
					
				if ($stolenIron > 0 || $stolenBeryllium > 0 || $stolenEnergy > 0) {
					$loserReportText .= '<br/><br/>Die gegnerischen Truppen erbeuteten folgende Rohstoffe:';
					$winnerReportText .= '<br/><br/>Die folgenden Rohstoffe konnten erbeutet werden:';
					if ($stolenIron > 0) {
						$loserReportText .= '<br/>'.Text::formatNumber($stolenIron).' Eisen';
						$winnerReportText .= '<br/>'.Text::formatNumber($stolenIron).' Eisen';
					}
					if ($stolenBeryllium > 0) {
						$loserReportText .= '<br/>'.Text::formatNumber($stolenBeryllium).' Beryllium';
						$winnerReportText .= '<br/>'.Text::formatNumber($stolenBeryllium).' Beryllium';
					}
					if ($stolenEnergy > 0) {
						$loserReportText .= '<br/>'.Text::formatNumber($stolenEnergy).' Energie';
						$winnerReportText .= '<br/>'.Text::formatNumber($stolenEnergy).' Energie';
					}
					$targetRessources->lower($stolenIron, $stolenBeryllium, $stolenEnergy);
					$army->iron = $stolenIron;
					$army->beryllium = $stolenBeryllium;
					$army->energy = $stolenEnergy;
					Rakuun_Intern_Log_Ressourcetransfer::log($army->user, Rakuun_Intern_Log::ACTION_RESSOURCES_FIGHT, $army->target, $stolenIron, $stolenBeryllium, $stolenEnergy);
				}
				else {
					$loserReportText .= '<br/><br/>Die gegnerischen Truppen haben keine Rohstoffe gestohlen.';
					$winnerReportText .= '<br/><br/>Es konnten leider keine Rohstoffe erbeutet werden.';
				}
			
				// DESTROY BUILDINGS -------------------------------------------
				// calculate destruction probability (probability(force) = a * x^2)
				if ($army->destroyBuildings) {
					$survivingAttackForce = $fightingSystem->getTotalAttackingPower() - $fightingSystem->getTotalDefendingPower();
					$neededAttackForce = self::DESTRUCTION_NEEDED_FORCE_FOR_MAX;
					$enemiesAtWar = false;
					// only half of the attack force needed for maximum probability if there is war
					if ($army->user->alliance && $army->target->alliance) {
						$diplomacyRelation = $army->user->alliance->getDiplomacy($army->target->alliance);
						if ($diplomacyRelation && $diplomacyRelation->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_WAR) {
							$neededAttackForce /= 2;
							$enemiesAtWar = true;
						}
					}
					$probability = self::DESTRUCTION_MAX_PROBABILITY / pow($neededAttackForce, 2) * pow($survivingAttackForce, 2);
					if ($probability > self::DESTRUCTION_MAX_PROBABILITY)
						$probability = self::DESTRUCTION_MAX_PROBABILITY;
					if (rand(1, 100) <= $probability) {
						$destructibleBuildings = array();
						foreach (Rakuun_Intern_Production_Factory::getAllBuildings($army->target) as $building) {
							if ($building->getLevel() > $building->getMinimumLevel() && !$building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK)) {
								$canBeDestroyed = true;
								if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_DESTRUCTIBLE_UNTIL_AVERAGE_IN_WAR)) {
									$canBeDestroyed = false;
									$options = array();
									$options['properties'] = $properties[] = 'SUM('.$building->getInternalName().') AS '.$building->getInternalName().'_sum';
									$averageLevel = round(Rakuun_DB_Containers::getBuildingsContainer()->selectFirst($options)->{Text::underscoreToCamelCase($building->getInternalName().'_sum')} / Rakuun_Intern_Statistics::noOfPlayers());
									if ($building->getLevel() > $averageLevel && $enemiesAtWar)
										$canBeDestroyed = true;
								}
								
								if ($canBeDestroyed)
									$destructibleBuildings[] = $building;
							}
						}
						if ($destructibleBuildings) {
							$shieldGenerator = Rakuun_Intern_Production_Factory::getBuilding('shield_generator', $army->target);
							if ($shieldGenerator->getLevel() > 0 && !$shieldGenerator->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK))
								$destroyedBuilding = $shieldGenerator;
							else
								$destroyedBuilding = $destructibleBuildings[rand(0, count($destructibleBuildings) - 1)];
							$army->target->buildings->lower($destroyedBuilding->getInternalName(), $army->user);
							
							//raiseRessourcesForDestroyedBuilding
							$iron = $destroyedBuilding->getIronRepayForLevel();
							$beryllium = $destroyedBuilding->getBerylliumRepayForLevel();
							$energy = $destroyedBuilding->getEnergyRepayForLevel();
							$people = $destroyedBuilding->getPeopleRepayForLevel();
							$destroyedBuilding->getUser()->ressources->raise($iron, $beryllium, $energy, $people);
							
							// remove workers from producers
							if ($destroyedBuilding instanceof Rakuun_Intern_Production_Building_RessourceProducer) {
								$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($army->target);
								// only change workers if amount > maxWorkersAmount
								if ($workers->{Text::underscoreToCamelCase($destroyedBuilding->getInternalName())} > $destroyedBuilding->getRequiredWorkers()) {
									$workers->{Text::underscoreToCamelCase($destroyedBuilding->getInternalName())} = $destroyedBuilding->getRequiredWorkers();
									$workers->save();
								}
							}
							// dancertia got destroyed
							if ($destroyedBuilding->getInternalName() == 'shield_generator' && $army->target->alliance && $army->target->alliance->meta
								&& $army->target->alliance->meta->dancertiaStarttime + RAKUUN_SPEED_DANCERTIA_STARTTIME > time() && !$army->target->alliance->meta->hasMemberWithShieldGenerator()
							) {
								$army->target->alliance->meta->dancertiaStarttime = 0;
								$army->target->alliance->meta->save();
								$army->target->alliance->meta->buildings->dancertia = 0;
								$army->target->alliance->meta->buildings->save();
								foreach (Rakuun_DB_Containers::getUserContainer()->select() as $user) {
									$igm = new Rakuun_Intern_IGM('Raumschiffabsturz!', $user);
									$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
									$igm->setText('Was für ein Knall! Was für ein Feuerwerk!
										<br/>
										...
										<br/>
										Achja, und brennende Wrackteile, die auf unsere Stadt herunterregnen. Naja, die werden wir schon wieder weggeräumt bekommen.
										<br/>
										<br/>
										Wie - Ihr wisst nicht, was passiert ist?
										<br/>
										Die Dancertia (dieses riesige Raumschiff, das in den letzten Tagen zu starten versucht wurde...na, ihr wisst schon) wurde vernichtet; vollkommen zerstört!
										<br/>
										Nun liegt es wohl an jemand anderem, die Herrschaft über diesen Planeten zu übernehmen...');
									$igm->send();
								}
							}
							$loserReportText .= '<br/><br/>Eine Stufe des Gebäudes '.$destroyedBuilding->getName().' wurde zerstört!';
							$winnerReportText .= '<br/><br/>Eine Stufe des Gebäudes '.$destroyedBuilding->getName().' konnte zerstört werden!';
							$defenderReportMarkers[] = Rakuun_Intern_IGM::ATTACHMENT_FIGHTREPORTMARKER_LOSTBUILDINGS;
						}
					}
				}
			}
			
			// save any changes to the army
			$army->save();
			
			if (!$fightingSystem->getDefenderWon() && $army->user->alliance && $army->canTransportDatabase()) {
				$visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance($army->user->alliance);
				if (!empty($visibleDatabases)) {
					$options = array();
					$options['conditions'][] = array('user = ?', $army->target);
					$options['conditions'][] = array('active = ?', true);
					$options['conditions'][] = array('identifier IN ('.implode(', ', $visibleDatabases).')');
					if ($database = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectFirst($options)) {
						$databaseSpecial = new Rakuun_User_Specials_Database($army->user, $database->identifier, true);
						$databaseSpecial->giveSpecial();
						
						$loserReportText .= '<br/><br/>Es wurde ein Datenbankteil gestohlen!';
						$winnerReportText .= '<br/><br/>Es wurde ein Datenbankteil erobert!';
					}
				}
			}
			
			// assign report texts to defender / attacker
			$defenderReportText .= $loserReportText;
			$attackerReportText .= $winnerReportText;
		}
		
		$defenderReport = new Rakuun_Intern_IGM('Verteidigung gegen '.$army->user->nameUncolored, $army->target, $defenderReportText, Rakuun_Intern_IGM::TYPE_FIGHT);
		$defenderReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
		$defenderReport->addAttachment(Rakuun_Intern_IGM::ATTACHMENT_TYPE_FIGHTREPORTMARKERS, implode(',', $defenderReportMarkers));
		$defenderReport->send();
		
		$attackerReport = new Rakuun_Intern_IGM('Angriff auf '.$army->target->nameUncolored, $army->user, $attackerReportText, Rakuun_Intern_IGM::TYPE_FIGHT);
		$attackerReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
		$attackerReport->addAttachment(Rakuun_Intern_IGM::ATTACHMENT_TYPE_FIGHTREPORTMARKERS, implode(',', $attackerReportMarkers));
		$attackerReport->send();
	}
	
	private function spy(Rakuun_DB_Army $army) {
		$spyReportLogEntry = null;
		$spyDronesSurvive = false;
		$successfullCloakedSpy = false;
		
		$defendingPower = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($army->target) as $unit) {
			$defendingPower += $unit->getDefenseValue();
		}
		
		$userAllianceLink = '';
		$targetAllianceLink = '';
		if ($army->user->alliance) {
			$link = new Rakuun_GUI_Control_AllianceLink('alliance_link', $army->user->alliance);
			$link->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			$userAllianceLink = $link->render();
		}
		if ($army->target->alliance) {
			$link = new Rakuun_GUI_Control_AllianceLink('alliance_link', $army->target->alliance);
			$link->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			$targetAllianceLink = $link->render();
		}
		$link = new Rakuun_GUI_Control_UserLink('user_link', $army->user);
		$userLink = $link->render();
		$link = new Rakuun_GUI_Control_UserLink('target_link', $army->target);
		$targetLink = $link->render();
		
		// the higher $reportCompletenessIndicator, the incompleter the report
		$reportCompletenessIndicator = $defendingPower / ($army->spydrone + $army->cloakedSpydrone * Rakuun_Intern_Production_Unit_CloakedSpydrone::ROBUSTNESS_FACTOR);
		if ($reportCompletenessIndicator >= 4000) {
			$defenderReportText = 'Soeben versuchte '.$userLink.$userAllianceLink.' geheime Daten unserer Stadt auszuspionieren - glücklicherweiße gelang es unserer Armee die feindlichen Spionagesonden zu zerstören, bevor diese Daten übermitteln konnten.';
			$attackerReportText = 'Leider schlug die Ausspionierung von '.$targetLink.$targetAllianceLink.' fehl - die gegnerische Armee zerstöre sämtliche Spionagesonden, bevor diese Daten übermitteln konnten.';
		}
		else {
			$spiedRessourcesContainer = $army->target->ressources;
			$spiedBuildings = array();
			$spiedUnits = array();
			
			$previousReport = Rakuun_Intern_GUI_Panel_Reports_Base::getNewestReportForUser($army->target, $army->user);
			
			$defenderReportText = 'Soeben wurden geheime Daten unserer Stadt von '.$userLink.$userAllianceLink.' ausspioniert!';
			$attackerReportText = 'Soeben gelang es einigen unserer Spionagesonden, geheime Daten von '.$targetLink.$targetAllianceLink.' zu übermitteln!';
			
			if ($reportCompletenessIndicator <= 2000) {
				$defenderReportText .= '<br/>Folgende Informationen konnten die gegnerischen Sonden übermitteln:';
				$attackerReportText .= '<br/>Folgende Informationen konnten wir erhalten:';
			}
			else {
				$defenderReportText .= '<br/>Bevor unsere Armee die gegnerischen Sonden zerstören konnte, wurden folgende Informationen übermittelt:';
				$attackerReportText .= '<br/>Leider wurden unsere Sonden zerstört, doch zuvor erhielten wir folgende Informationen:';
			}
				
			$defenderReportText .= '<br/><br/>Die Menge der in unseren Lagern befindlichen Rohstoffe:';
			$attackerReportText .= '<br/><br/>Folgende Rohstoffe konnten ausfindig gemacht werden:';
			$spiedRessourcesText = '';
			$spiedRessourcesText .= '<br/>'.Text::formatNumber((int)$army->target->ressources->iron).' Eisen';
			$spiedRessourcesText .= '<br/>'.Text::formatNumber((int)$army->target->ressources->beryllium).' Beryllium';
			$spiedRessourcesText .= '<br/>'.Text::formatNumber((int)$army->target->ressources->energy).' Energie';
			$defenderReportText .= $spiedRessourcesText;
			$attackerReportText .= $spiedRessourcesText;
			
			if ($reportCompletenessIndicator <= 3000) {
				$spiedBuildingsContainer = $army->target->buildings;
				$defenderReportText .= '<br/><br/>Die Ausbaustufen unserer Gebäude:';
				$attackerReportText .= '<br/><br/>Folgende Gebäude hat euer Gegner:';
				$spiedBuildingsReportText = '';
				foreach (Rakuun_Intern_Production_Factory::getAllBuildings($army->target) as $building) {
					if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES) === true)
						continue;
					
					if ($building->getLevel() > 0) {
						$delta = ($previousReport) ? $building->getLevel() - $previousReport->{Text::underscoreToCamelCase($building->getInternalName())} : $building->getLevel();
						$deltaIcon = new Rakuun_Intern_GUI_Panel_Reports_DeltaIcon('delta'.$building->getInternalName(), $delta);
						$spiedBuildingsReportText .= '<br/>'.$building->getName().' (Stufe '.$building->getLevel().' '.$deltaIcon->render().')';
						$spiedBuildings[$building->getInternalName()] = $building->getLevel();
					}
				}
				$defenderReportText .= $spiedBuildingsReportText;
				$attackerReportText .= $spiedBuildingsReportText;
			}
			
			if ($reportCompletenessIndicator <= 2000) {
				$spiedUnitsContainer = $army->target->units;
				$defenderReportText .= '<br/><br/>Die Anzahl unserer Einheiten:';
				$attackerReportText .= '<br/><br/>Folgende Einheiten wurden entdeckt:';
				
				$successfullEnhancedCloaking = false;
				if ($army->target->technologies->enhancedCloaking > 0 && $army->cloakedSpydrone < $army->spydrone)
					$successfullEnhancedCloaking = true;
				
				$unitsText = '';
				foreach (Rakuun_Intern_Production_Factory::getAllUnits($army->target) as $unit) {
					if ($unit->getAmount() > 0 && (!$successfullEnhancedCloaking || !$unit->getAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_CLOAKING))) {
						$delta = ($previousReport) ? $unit->getAmount() - $previousReport->{Text::underscoreToCamelCase($unit->getInternalName())} : $unit->getAmount();
						$deltaIcon = new Rakuun_Intern_GUI_Panel_Reports_DeltaIcon('delta'.$unit->getInternalName(), $delta);
						$unitsText .= '<br/>'.Text::formatNumber((int)$unit->getAmount()).' '.$unit->getNameForAmount().' '.$deltaIcon->render();
						$spiedUnits[$unit->getInternalName()] = $unit->getAmount();
					}
				}
				if (!$unitsText)
					$unitsText = '<br/>Keine.';
				$defenderReportText .= $unitsText;
				$attackerReportText .= $unitsText;
				
				if ($army->cloakedSpydrone > 0 && $army->spydrone == 0)
					$successfullCloakedSpy = true;
				
				$spyDronesSurvive = true;
			}
			
			$spyReportLogEntry = Rakuun_Intern_Log_Spies::log($army->user, $army->target, $spiedRessourcesContainer, $spiedBuildings, $spiedUnits);
		}
		
		if (!$successfullCloakedSpy) {
			$defenderReport = new Rakuun_Intern_IGM('Spionage von '.$army->user->nameUncolored, $army->target, $defenderReportText, Rakuun_Intern_IGM::TYPE_SPY);
			$defenderReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
			$defenderReport->send();
		}
		
		if ($spyDronesSurvive) {
			$army->moveHome();
		}
		else {
			Rakuun_Intern_Log_Fights::logSpy($army->user, $army->target, array('spydrone' => $army->spydrone, 'cloaked_spydrone' => $army->cloakedSpydrone), $army->getPK());
			$army->delete();
		}
		
		$attackerReport = new Rakuun_Intern_IGM('Ausspionierung von '.$army->target->nameUncolored, $army->user, $attackerReportText, Rakuun_Intern_IGM::TYPE_SPY);
		$attackerReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
		if ($spyReportLogEntry)
			$attackerReport->addAttachment(Rakuun_Intern_IGM::ATTACHMENT_TYPE_SPYREPORTLOG, $spyReportLogEntry->getPK());
		$attackerReport->send();
	}
	
	/**
	 * Executed if an army returns home
	 */
	private function returnHome(Rakuun_DB_Army $army) {
		$options = array();
		$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
		$userUnits = Rakuun_DB_Containers::getUnitsContainer()->selectByUserFirst($army->user, $options);
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($army) as $unit) {
			if ($unit->getAmount() > 0) {
				$userUnits->{Text::underscoreToCamelCase($unit->getInternalName())} += $unit->getAmount();
			}
		}
		$userUnits->save();
		$options = array();
		$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
		$ressources = Rakuun_DB_Containers::getRessourcesContainer()->selectByUserFirst($army->user, $options);
		$ressources->raise($army->iron, $army->beryllium, $army->energy);
		$army->delete();
	}
	
	private function raiseRessourcesForDestroyedBuilding($destroyedBuilding) {
		//DB_Connection::get()->beginTransaction();
		
		//DB_Connection::get()->commit();
	}
	
	private function destroyBuildings($army, $fightingSystem) {
		
	}
}

?>