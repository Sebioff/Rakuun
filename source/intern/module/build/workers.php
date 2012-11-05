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

class Rakuun_Intern_Module_Build_Workers extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Arbeiter verwalten');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/workers.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_ironmine', Rakuun_Intern_Production_Factory::getBuilding('ironmine')));
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_berylliummine', Rakuun_Intern_Production_Factory::getBuilding('berylliummine')));
		if (Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getLevel() > 0)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_clonomat', Rakuun_Intern_Production_Factory::getBuilding('clonomat')));
		if (Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getLevel() > 0)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_hydropower_plant', Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')));
	}
}

?>