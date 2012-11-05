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

/**
 * Class that is responsible for producing items for alliances
 */
class Rakuun_Intern_Production_Producer_Metas extends Rakuun_Intern_Production_Producer {
	public function __construct(Rakuun_DB_Meta $meta) {
		parent::__construct(Rakuun_DB_Containers::getMetasBuildingsContainer(), Rakuun_DB_Containers::getMetasBuildingsWIPContainer(), $meta, 'meta');
		$this->setPauseOnMissingRequirements(false);
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function addWIPItem(DB_Record $wipItem) {
		$wipObject = Rakuun_Intern_Production_Factory_Metas::getBuilding($wipItem->building, $this->getProductionTarget());
		$newWip = new Rakuun_Intern_Production_WIP($wipObject->getInternalName().$wipItem->getPK(), $this, $wipObject);
		$newWip->setLevel($wipItem->level);
		$newWip->setStartTime($wipItem->starttime);
		$newWip->setRecord($wipItem);
		$this->wip[] = $newWip;
	}
	
	protected function onFinishedProduction(Rakuun_Intern_Production_Base $producedItem) {
		if ($producedItem->getInternalName() == 'dancertia') {
			$this->getProductionTarget()->dancertiaStarttime = time();
			$this->getProductionTarget()->save();
		}
	}
	
	public function cancelWIPItem(Rakuun_Intern_Production_WIP $wipItem) {
		throw new Core_Exception('Can\'t cancel items of this queue.');
	}
}

?>