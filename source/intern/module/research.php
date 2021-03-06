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

class Rakuun_Intern_Module_Research extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Forschen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/research.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_CityItems('wip', new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getTechnologiesContainer(), Rakuun_DB_Containers::getTechnologiesWIPContainer()), 'Momentane Forschung');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$canResearch = false;
		$sortpane = new GUI_Panel_Sortable('sortpane', Rakuun_User_Manager::getCurrentUser(), 'sequence_technologies');
		$sortpane->setHandle('.head, .production_item_header');
		$this->contentPanel->addPanel($sortpane);
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if ($technology->meetsTechnicalRequirements() || $technology->getLevel() > 0) {
				$sortpane->addPanel($itemBox = new Rakuun_GUI_Panel_Box('build_'.$technology->getInternalName(), new Rakuun_Intern_GUI_Panel_Production_Research('build_'.$technology->getInternalName(), $technology)));
				$itemBox->addClasses('production_item_box');
				$canResearch = true;
			}
		}
		if (!$canResearch) {
			$link = new GUI_Control_Link('techtree', 'Voraussetzungen', App::get()->getInternModule()->getSubmodule('techtree')->getUrl());
			$this->contentPanel->addPanel(new GUI_Panel_Text('information', 'Forschen derzeit nicht möglich - es wurden noch keine '.$link->render().' für eine Forschung erfüllt.'));
		}
	}
}

?>