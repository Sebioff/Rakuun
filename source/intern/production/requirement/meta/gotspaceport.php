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
 * Checks if the meta owns a space port
 */
class Rakuun_Intern_Production_Requirement_Meta_GotSpacePort extends Rakuun_Intern_Production_Requirement_Base {
	public function getDescription() {
		return 'Meta muss einen Raumhafen besitzen';
	}
	
	public function fulfilled() {
		if (!$this->getProductionItem()->getOwner()->alliance || !$this->getProductionItem()->getOwner()->alliance->meta)
			return false;
		
		$spacePort = Rakuun_Intern_Production_Factory_Metas::getBuilding('space_port', $this->getProductionItem()->getOwner()->alliance->meta);
		return ($spacePort->getLevel() >= 1);
	}
}

?>