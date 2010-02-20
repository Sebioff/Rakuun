<?php

class Rakuun_Cronjob_Script_Fight extends Rakuun_Cronjob_Script {
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
				else if($army->targetX == $army->user->cityX && $army->targetY == $army->user->cityY) {
					$this->returnHome($army);
				}
				// army reached some target anywhere on the map
				else {
					if ($army->user->alliance && $this->canTransportDatabase($army)) {
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
							}
						}
					}
					
					// make army return home
					$army->targetX = $army->user->cityX;
					$army->targetY = $army->user->cityY;
					$army->tick = time();
					$army->targetTime = 0;
					$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
					$pathCalculator->getPath();
					$army->save();
				}
			}
			DB_Connection::get()->commit();
		}
	}
	
	private function fight(DB_Record $army) {
		$playersAreAllied =	($army->user->alliance && $army->target->alliance && $army->user->alliance->getPK() == $army->target->alliance->getPK());
		if (!$playersAreAllied && $army->user->alliance && $army->target->alliance && $diplomacy = $army->user->alliance->getDiplomacy($army->target->alliance)) {
			$playersAreAllied = ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_AUVB);
		}
		
		$fightingSystem = new Rakuun_Intern_Fights_System($playersAreAllied);
		$fightingSystem->fight($army, $army->target->units);
		
		if ($fightingSystem->getDefenderWon()) {
			$winnerUnitSource = $army->target->units;
			$looserUnitSource = $army;
			$survivingWinnerUnitAmounts = $fightingSystem->getSurvivingDefendingUnitAmounts();
			$survivingLooserUnitAmounts = $fightingSystem->getSurvivingAttackingUnitAmounts();
			$defenderReportText = 'Wir wurden angegriffen!<br/>Eine feindliche Armee von '.$army->user->name.' versuchte unsere Stadt zu überfallen, doch wir konnten den Feind erfolgreich abwehren.';
			$attackerReportText = 'Einer Ihrer Angriffe war eine Niederlage!<br/>Beim Überfall auf '.$army->target->name.' wurde unsere Armee vernichtend geschlagen.';
		}
		else {
			$winnerUnitSource = $army;
			$looserUnitSource = $army->target->units;
			$survivingWinnerUnitAmounts = $fightingSystem->getSurvivingAttackingUnitAmounts();
			$survivingLooserUnitAmounts = $fightingSystem->getSurvivingDefendingUnitAmounts();
			$defenderReportText = 'Wir wurden angegriffen!<br/>Eine feindliche Armee von '.$army->user->name.' überfiel unsere Stadt und vernichtete unsere Armee.';
			$attackerReportText = 'Einer Ihrer Angriffe war ein Erfolg!<br/>Beim Überfall auf '.$army->target->name.' wurde die gegnerische Armee vernichtend geschlagen.';
		}
			
		// WINNER ----------------------------------------------
		// report for winner
		$winnerReportText = '<br/><br/>Folgende Verluste sind zu beklagen:';
		$deadWinnerUnitsText = '';
		foreach ($survivingWinnerUnitAmounts as $unitName => $unitAmount) {
			$unit = Rakuun_Intern_Production_Factory::getUnit($unitName, $winnerUnitSource);
			$deadUnitAmount = $unit->getAmount() - $unitAmount;
			if ($deadUnitAmount > 0) {
				$deadWinnerUnitsText .= '<br/>'.GUI_Panel_Number::formatNumber($deadUnitAmount).'/'.GUI_Panel_Number::formatNumber($unit->getAmount()).' '.$unit->getNameForAmount();
				// delete winner units
				$winnerUnitSource->{Text::underscoreToCamelCase($unitName)} -= $deadUnitAmount;
			}
		}
		$winnerUnitSource->save();
		if ($deadWinnerUnitsText)
			$winnerReportText .= $deadWinnerUnitsText;
		else
			$winnerReportText .= '<br/>Keine.';
		$deadLooserUnitsText = '';
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($looserUnitSource) as $unit) {
			if ($unit->getAmount() > 0 && !$unit->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK)) {
				$deadUnitAmount = $unit->getAmount();
				if (isset($survivingLooserUnitAmounts[$unit->getInternalName()]))
					$deadUnitAmount = $unit->getAmount() - $survivingLooserUnitAmounts[$unit->getInternalName()];
				if ($deadUnitAmount > 0) {
					$deadLooserUnitsText .= '<br/>'.GUI_Panel_Number::formatNumber($deadUnitAmount).' '.$unit->getNameForAmount($deadUnitAmount);
					// delete looser units
					$looserUnitSource->{Text::underscoreToCamelCase($unit->getInternalName())} -= $deadUnitAmount;
				}
			}
		}
		$looserUnitSource->save();
		if ($deadLooserUnitsText)
			$winnerReportText .= '<br/><br/>Die gegnerische Armee wurde vollständig vernichtet:'.$deadLooserUnitsText;
		else
			$winnerReportText .= '<br/><br/>Es wurden keine gegnerischen Einheiten vernichtet.';
		
		// LOOSER ----------------------------------------------
		//report for looser
		if (!$deadLooserUnitsText)
			$deadLooserUnitsText = '<br/>Keine.';
		$looserReportText = '<br/><br/>Folgende Verluste sind zu beklagen:'.$deadLooserUnitsText;
		if ($deadWinnerUnitsText) {
			$looserReportText .= '<br/><br/>Der gegnerischen Armee konnte folgender Schaden zugefügt werden:'.$deadWinnerUnitsText;
			$looserReportText .= '<br/>Möglicherweiße besaß der Gegner sogar weitere Einheiten, die von unseren Truppen nicht einmal entdeckt werden konnten.';
		}
		else {
			$looserReportText .= '<br/><br/>Es wurden keine gegnerischen Einheiten vernichtet.';
		}
		
		if ($fightingSystem->getDefenderWon()) {
			$defenderReportText .= $winnerReportText;
			$attackerReportText .= $looserReportText;
			
			// delete attacking army
			$army->delete();
		}
		else {
			// make army return home
			$army->targetX = $army->user->cityX;
			$army->targetY = $army->user->cityY;
			$army->tick = time();
			$army->targetTime = 0;
			$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
			$pathCalculator->getPath();
			
			// STEALING RESSOURCES ---------------------------------
			if (!$playersAreAllied) {
				$totalPriority = $army->ironPriority + $army->berylliumPriority + $army->energyPriority;
				$totalCapacity = 0;
				foreach (Rakuun_Intern_Production_Factory::getAllUnits($army) as $unit) {
					$totalCapacity += $unit->getRessourceTransportCapacity();
				}
				
				$maxIronCapacity = $totalCapacity * $army->ironPriority / $totalPriority;
				$maxBerylliumCapacity = $totalCapacity * $army->berylliumPriority / $totalPriority;
				$maxEnergyCapacity = $totalCapacity * $army->energyPriority / $totalPriority;
				
				$takeableIron = $army->target->ressources->iron - $army->target->ressources->getSaveCapacityIron();
				if ($takeableIron < 0)
					$takeableIron = 0;
				$takeableBeryllium = $army->target->ressources->beryllium - $army->target->ressources->getSaveCapacityBeryllium();
				if ($takeableBeryllium < 0)
					$takeableBeryllium = 0;
				$takeableEnergy = $army->target->ressources->energy - $army->target->ressources->getSaveCapacityEnergy();
				if ($takeableEnergy < 0)
					$takeableEnergy = 0;
					
				$stolenIron = rand($maxIronCapacity * 1 / 30, $maxIronCapacity);
				$stolenBeryllium = rand($maxBerylliumCapacity * 1 / 30, $maxBerylliumCapacity);
				$stolenEnergy = rand($maxEnergyCapacity * 1 / 30, $maxEnergyCapacity);
				
				if ($stolenIron > $takeableIron)
					$stolenIron = $takeableIron;
				if ($stolenBeryllium > $takeableBeryllium)
					$stolenBeryllium = $takeableBeryllium;
				if ($stolenEnergy > $takeableEnergy)
					$stolenEnergy = $takeableEnergy;
					
				if ($stolenIron > 0 || $stolenBeryllium > 0 || $stolenEnergy > 0) {
					$looserReportText .= '<br/><br/>Die gegnerischen Truppen erbeuteten folgende Rohstoffe:';
					$winnerReportText .= '<br/><br/>Die folgenden Rohstoffe konnten erbeutet werden:';
					if ($stolenIron > 0) {
						$looserReportText .= '<br/>'.GUI_Panel_Number::formatNumber($stolenIron).' Eisen';
						$winnerReportText .= '<br/>'.GUI_Panel_Number::formatNumber($stolenIron).' Eisen';
					}
					if ($stolenBeryllium > 0) {
						$looserReportText .= '<br/>'.GUI_Panel_Number::formatNumber($stolenBeryllium).' Beryllium';
						$winnerReportText .= '<br/>'.GUI_Panel_Number::formatNumber($stolenBeryllium).' Beryllium';
					}
					if ($stolenEnergy > 0) {
						$looserReportText .= '<br/>'.GUI_Panel_Number::formatNumber($stolenEnergy).' Energie';
						$winnerReportText .= '<br/>'.GUI_Panel_Number::formatNumber($stolenEnergy).' Energie';
					}
					$army->target->ressources->lower($stolenIron, $stolenBeryllium, $stolenEnergy);
					$army->iron = $stolenIron;
					$army->beryllium = $stolenBeryllium;
					$army->energy = $stolenEnergy;
				}
				else {
					$looserReportText .= '<br/><br/>Die gegnerischen Truppen haben keine Rohstoffe gestohlen.';
					$winnerReportText .= '<br/><br/>Es konnten leider keine Rohstoffe erbeutet werden.';
				}
			
				// DESTROY BUILDINGS -----------------------------------
				// calculate destruction probability (probability(force) = a * x^2)
				if ($army->destroyBuildings) {
					$survivingAttackForce = $fightingSystem->getTotalAttackingPower() - $fightingSystem->getTotalDefendingPower();
					$neededAttackForce = self::DESTRUCTION_NEEDED_FORCE_FOR_MAX;
					// only half of the attack force needed for maximum probability if there is war
					if ($army->user->alliance && $army->target->alliance) {
						if ($diplomacyRelation = $army->user->alliance->getDiplomacy($army->target->alliance) && $diplomacyRelation->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_WAR) {
							$neededAttackForce /= 2;
						}
					}
					$probability = self::DESTRUCTION_MAX_PROBABILITY / pow($neededAttackForce, 2) * pow($survivingAttackForce, 2);
					if ($probability > self::DESTRUCTION_MAX_PROBABILITY)
						$probability = self::DESTRUCTION_MAX_PROBABILITY;
					if (rand(1, 100) <= $probability) {
						$destructibleBuildings = array();
						foreach (Rakuun_Intern_Production_Factory::getAllBuildings($army->target) as $building) {
							if ($building->getLevel() > $building->getMinimumLevel() && !$building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK)) {
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
							$looserReportText .= '<br/><br/>Eine Stufe des Gebäudes '.$destroyedBuilding->getName().' wurde zerstört!';
							$winnerReportText .= '<br/><br/>Eine Stufe des Gebäudes '.$destroyedBuilding->getName().' konnte zerstört werden!';
						}
					}
				}
			}
			
			// save any changes to the army
			$army->save();
			
			if (!$fightingSystem->getDefenderWon() && $army->user->alliance && $this->canTransportDatabase($army)) {
				$visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance($army->user->alliance);
				if (!empty($visibleDatabases)) {
					$options = array();
					$options['conditions'][] = array('user = ?', $army->target);
					$options['conditions'][] = array('active = ?', true);
					$options['conditions'][] = array('identifier IN ('.implode(', ', $visibleDatabases).')');
					if ($database = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectFirst($options)) {
						$databaseSpecial = new Rakuun_User_Specials_Database($army->user, $database->identifier, true);
						$databaseSpecial->giveSpecial();
						
						$looserReportText .= '<br/><br/>Es wurde ein Datenbankteil gestohlen!';
						$winnerReportText .= '<br/><br/>Es wurde ein Datenbankteil erobert!';
					}
				}
			}
			
			// assign report texts to defender / attacker
			$defenderReportText .= $looserReportText;
			$attackerReportText .= $winnerReportText;
		}
		
		$defenderReport = new Rakuun_Intern_IGM('Verteidigung gegen '.$army->user->nameUncolored, $army->target, $defenderReportText, Rakuun_Intern_IGM::TYPE_FIGHT);
		$defenderReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
		$defenderReport->send();
		
		$attackerReport = new Rakuun_Intern_IGM('Angriff auf '.$army->target->nameUncolored, $army->user, $attackerReportText, Rakuun_Intern_IGM::TYPE_FIGHT);
		$attackerReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
		$attackerReport->send();
	}
	
	private function spy(DB_Record $army) {
		$spyDronesSurvive = false;
		$successfullCloakedSpy = false;
		$defendingPower = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($army->target) as $unit) {
			$defendingPower += $unit->getDefenseValue();
		}
		
		// the higher $reportCompletenessIndicator, the incompleter the report
		$reportCompletenessIndicator = $defendingPower / ($army->spydrone + $army->cloakedSpydrone * Rakuun_Intern_Production_Unit_CloakedSpydrone::ROBUSTNESS_FACTOR);
		if ($reportCompletenessIndicator >= 4000) {
			$defenderReportText = 'Soeben versuchte '.$army->user->name.' geheime Daten unserer Stadt auszuspionieren - glücklicherweiße gelang es unserer Armee die feindlichen Spionagesonden zu zerstören, bevor diese Daten übermitteln konnten.';
			$attackerReportText = 'Leider schlug die Ausspionierung von '.$army->target->name.' fehl - die gegnerische Armee zerstöre sämtliche Spionagesonden, bevor diese Daten übermitteln konnten.';
		}
		else {
			$defenderReportText = 'Soeben wurden geheime Daten unserer Stadt von '.$army->user->name.' ausspioniert!';
			$attackerReportText = 'Soeben gelang es einigen unserer Spionagesonden, geheime Daten von '.$army->target->name.' zu übermitteln!';
			
			if ($reportCompletenessIndicator <= 2000) {
				$defenderReportText .= '<br/>Folgende Informationen konnten die gegnerischen Sonden übermitteln:';
				$attackerReportText .= '<br/>Folgende Informationen konnten wir erhalten:';
			}
			else {
				$defenderReportText .= '<br/>Bevor unsere Armee die gegnerischen Sonden zerstören konnte, wurden folgende Informationen übermittelt:';
				$attackerReportText .= '<br/>Leider wurden unsere Sonden zerstört, doch zuvor erhielten wir folgende Informationen:';
			}
				
			$defenderReportText .= '<br/>Die Menge der in unseren Lagern befindlichen Rohstoffe';
			$attackerReportText .= '<br/><br/>Folgende Rohstoffe konnten ausfindig gemacht werden:';
			$attackerReportText .= '<br/>'.GUI_Panel_Number::formatNumber((int)$army->target->ressources->iron).' Eisen';
			$attackerReportText .= '<br/>'.GUI_Panel_Number::formatNumber((int)$army->target->ressources->beryllium).' Beryllium';
			$attackerReportText .= '<br/>'.GUI_Panel_Number::formatNumber((int)$army->target->ressources->energy).' Energie';
			
			if ($reportCompletenessIndicator <= 3000) {
				$defenderReportText .= '<br/>Die Ausbaustufen unserer Gebäude';
				$attackerReportText .= '<br/><br/>Folgende Gebäude hat euer Gegner:';
				foreach (Rakuun_Intern_Production_Factory::getAllBuildings($army->target) as $building) {
					if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES) === true)
						continue;
					
					if ($building->getLevel() > 0)
						$attackerReportText .= '<br/>'.$building->getName().' (Stufe '.$building->getLevel().')';
				}
			}
			
			if ($reportCompletenessIndicator <= 2000) {
				$defenderReportText .= '<br/>Die Anzahl unserer Einheiten';
				$attackerReportText .= '<br/><br/>Folgende Einheiten wurden entdeckt:';
				
				$successfullEnhancedCloaking = false;
				if ($army->target->technologies->enhancedCloaking > 0 && $army->cloakedSpydrone < $army->spydrone)
					$successfullEnhancedCloaking = true;
				
				$unitsText = '';
				foreach (Rakuun_Intern_Production_Factory::getAllUnits($army->target) as $unit) {
					if ($unit->getAmount() > 0 && (!$successfullEnhancedCloaking || !$unit->getAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_CLOAKING)))
						$unitsText .= '<br/>'.GUI_Panel_Number::formatNumber((int)$unit->getAmount()).' '.$unit->getNameForAmount();
				}
				if (!$unitsText)
					$unitsText = '<br/>Keine.';
				$attackerReportText .= $unitsText;
				
				if ($army->cloakedSpydrone > 0 && $army->spydrone == 0)
					$successfullCloakedSpy = true;
				
				$spyDronesSurvive = true;
			}
		}
		
		if (!$successfullCloakedSpy) {
			$defenderReport = new Rakuun_Intern_IGM('Spionage von '.$army->user->nameUncolored, $army->target, $defenderReportText, Rakuun_Intern_IGM::TYPE_SPY);
			$defenderReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
			$defenderReport->send();
		}
		
		if ($spyDronesSurvive) {
			$army->targetX = $army->user->cityX;
			$army->targetY = $army->user->cityY;
			$army->tick = time();
			$army->targetTime = 0;
			$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
			$pathCalculator->getPath();
			$army->save();
		}
		else {
			$army->delete();
		}
		
		$attackerReport = new Rakuun_Intern_IGM('Ausspionierung von '.$army->target->nameUncolored, $army->user, $attackerReportText, Rakuun_Intern_IGM::TYPE_SPY);
		$attackerReport->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
		$attackerReport->send();
	}
	
	private function returnHome(DB_Record $army) {
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($army) as $unit) {
			if ($unit->getAmount() > 0) {
				$userUnits = $army->user->units;
				$userUnits->{Text::underscoreToCamelCase($unit->getInternalName())} += $unit->getAmount();
			}
		}
		$userUnits->save();
		$army->user->ressources->raise($army->iron, $army->beryllium, $army->energy);
		$army->delete();
	}
	
	private function canTransportDatabase(DB_Record $army) {
		$attackPower = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($army) as $unit) {
			$attackPower += $unit->getAttackValue();
		}
		return ($attackPower >= 1000);
	}
}

?>