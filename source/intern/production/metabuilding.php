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

abstract class Rakuun_Intern_Production_MetaBuilding extends Rakuun_Intern_Production_CityItem {
	public function __construct(DB_Record $dataSource = null) {
		$meta = null;
		if (!$dataSource) {
			$meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
			$dataSource = $meta->buildings;
		}
		elseif ($dataSource instanceof Rakuun_DB_Meta) {
			$meta = $dataSource;
			$dataSource = $dataSource->buildings;
		}
		else {
			$meta = $dataSource->meta;
		}
		parent::__construct($dataSource, $meta);
	}
	
	/**
	 * Returns the amount of levels that are currently being build.
	 */
	public function getFutureLevels() {
		$options = array();
		$options['conditions'][] = array('meta = ?', $this->getOwner());
		$options['conditions'][] = array('building = ?', $this->getInternalName());
		return Rakuun_DB_Containers::getMetasBuildingsWIPContainer()->count($options);
	}
	
	public function meetsTechnicalRequirements() {
		foreach ($this->getNeededBuildings() as $internalName => $neededLevel) {
			if (Rakuun_Intern_Production_Factory_Metas::getBuilding($internalName, $this->getOwner())->getLevel() < $neededLevel)
				return false;
		}
		
		foreach ($this->getNeededRequirements() as $requirement) {
			if (!$requirement->fulfilled())
				return false;
		}
		
		return true;
	}
}

?>