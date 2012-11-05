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
 * Class that is responsible for producing citys items
 */
class Rakuun_Intern_Production_Producer_CityItems extends Rakuun_Intern_Production_Producer {
	public function __construct(DB_Container $itemContainer, DB_Container $itemWIPContainer, Rakuun_DB_User $user = null) {
		if (!$user)
			$user = Rakuun_User_Manager::getCurrentUser();
		parent::__construct($itemContainer, $itemWIPContainer, $user, 'user');
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function addWIPItem(DB_Record $wipItem) {
		if ($this->getItemContainer()->getTable() == 'buildings')
			$wipObject = Rakuun_Intern_Production_Factory::getBuilding($wipItem->building, $this->getProductionTarget());
		else
			$wipObject = Rakuun_Intern_Production_Factory::getTechnology($wipItem->technology, $this->getProductionTarget());
		$newWip = new Rakuun_Intern_Production_WIP_CityItem($wipObject->getInternalName().$wipItem->getPK(), $this, $wipObject);
		$newWip->setLevel($wipItem->level);
		$newWip->setStartTime($wipItem->starttime);
		$newWip->setRecord($wipItem);
		$this->wip[] = $newWip;
	}
	
	public function cancelWIPItem(Rakuun_Intern_Production_WIP $wipItem) {
		DB_Connection::get()->beginTransaction();
		$this->getProductionTarget()->ressources->raise($wipItem->getWIPItem()->getIronRepayForLevel(), $wipItem->getWIPItem()->getBerylliumRepayForLevel(), $wipItem->getWIPItem()->getEnergyRepayForLevel(), $wipItem->getWIPItem()->getPeopleRepayForLevel());
		$options = $this->getWIPItemsOptions();
		$options['conditions'][] = array('position > ?', $wipItem->getRecord()->position);
		foreach ($this->getItemWIPContainer()->select($options) as $wipRecord) {
			$wipRecord->starttime = time();
			$wipRecord->save();
		}
		$wipItem->getRecord()->delete();
		DB_Connection::get()->commit();
	}
}

?>