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

class Rakuun_Intern_Module_Alliance_Build extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Allianzgebäude bauen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/build.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Alliance('wip', new Rakuun_Intern_Production_Producer_Alliances(Rakuun_User_Manager::getCurrentUser()->alliance), 'Momentaner Bauvorgang');
		$this->contentPanel->addPanel($wipPanel, true);
		
		foreach (Rakuun_Intern_Production_Factory_Alliances::getAllBuildings() as $building) {
			$this->contentPanel->addPanel($itemBox = new Rakuun_GUI_Panel_Box('build_'.$building->getInternalName(), new Rakuun_Intern_GUI_Panel_Production_Alliance('build_'.$building->getInternalName(), $building)));
			$itemBox->addClasses('production_item_box');
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}

?>