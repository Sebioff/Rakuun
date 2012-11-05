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

class Rakuun_Intern_Module_Produce extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Einheiten produzieren');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/produce.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Units('wip', new Rakuun_Intern_Production_Producer_Units(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers::getUnitsWIPContainer()), 'Momentane Einheitenproduktion');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$canProduce = false;
		$sortpane = new GUI_Panel_Sortable('sortpane', Rakuun_User_Manager::getCurrentUser(), 'sequence_units');
		$sortpane->setHandle('.head, .production_item_header');
		$this->contentPanel->addPanel($sortpane);
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->meetsTechnicalRequirements()) {
				$sortpane->addPanel($itemBox = new Rakuun_GUI_Panel_Box('produce_'.$unit->getInternalName(), new Rakuun_Intern_GUI_Panel_Production_Unit('produce_'.$unit->getInternalName(), $unit)));
				$itemBox->addClasses('production_item_box');
				$canProduce = true;
			}
		}
		if (!$canProduce) {
			$link = new GUI_Control_Link('techtree', 'Voraussetzungen', App::get()->getInternModule()->getSubmodule('techtree')->getUrl());
			$this->contentPanel->addPanel(new GUI_Panel_Text('information', 'Produktion derzeit nicht möglich - es wurden noch keine '.$link->render().' für eine Einheit erfüllt.'));
		}
	}
}

?>