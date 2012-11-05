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

class Rakuun_Intern_Map_ArmyPathCalculator {
	private $army = null;
	
	public function __construct(Rakuun_DB_Army $army) {
		$this->army = $army;
	}
	
	public function getPath() {
		$speed = 0;
		$canAllMoveOverWater = true;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($this->army) as $unit) {
			if ($unit->getAmount() <= 0)
				continue;
			if (!$unit->getAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_MOVE_OVER_WATER))
				$canAllMoveOverWater = false;
			if ($unit->getSpeed() > $speed)
				$speed = $unit->getSpeed();
		}
		$speed *= $this->army->speedMultiplier;
		$astar = new Rakuun_Intern_Map_AStar($speed, $canAllMoveOverWater);
		$options = array();
		$options['order'] = 'ID ASC';
		$pathNodes = Rakuun_DB_Containers::getArmiesPathsContainer()->selectByArmy($this->army, $options);
		if (!$pathNodes) {
			$path = $astar->run($this->army->positionX, $this->army->positionY, $this->army->targetX, $this->army->targetY);
			$pathNodes = array();
			DB_Connection::get()->beginTransaction();
			foreach ($path as $pathNode) {
				$pathNodeRecord = new DB_Record();
				$pathNodeRecord->army = $this->army;
				$pathNodeRecord->x = $pathNode['x'];
				$pathNodeRecord->y = $pathNode['y'];
				Rakuun_DB_Containers::getArmiesPathsContainer()->save($pathNodeRecord);
				$pathNodes[] = $pathNodeRecord;
			}
			DB_Connection::get()->commit();
		}
		else {
			$path = array();
			foreach ($pathNodes as $pathNode) {
				$path[] = &$astar->getMapNode($pathNode->x, $pathNode->y);
			}
		}
		
		if (empty($path))
			return $path;
		
		$movedTime = time() - $this->army->tick;
		
		$pathNodeCount = count($path);
		$moved = false;
		DB_Connection::get()->beginTransaction();
		for ($i = 0; $i < $pathNodeCount - 1; $i++) {
			$movementCosts = $astar->getMovementCosts($path[$i], $path[$i + 1]);
			if ($movedTime >= $movementCosts) {
				array_shift($path);
				$pathNode = array_shift($pathNodes);
				$pathNode->delete();
				$pathNodeCount--;
				$i--;
				$movedTime -= $movementCosts;
				$moved = true;
			}
			else {
				break;
			}
		}
		DB_Connection::get()->commit();
		
		if ($moved || !$this->army->targetTime) {
			$pathNodeCount = count($path);
			$targetTime = time() - $movedTime;
			for ($i = 0; $i < $pathNodeCount - 1; $i++) {
				$targetTime += $astar->getMovementCosts($path[$i], $path[$i + 1]);
			}
			$this->army->positionX = $path[0]['x'];
			$this->army->positionY = $path[0]['y'];
			$this->army->tick = time() - $movedTime;
			$this->army->targetTime = $targetTime;
			$this->army->save();
		}

		return $path;
	}
}

?>