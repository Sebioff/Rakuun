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
 * Displays information about units, buildings, technologies or users
 */
class Rakuun_Intern_Module_Info extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Info');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/info.tpl');
		
		if ($this->getParam('type') == 'building') {
			$productionItem = Rakuun_Intern_Production_Factory::getBuilding($this->getParam('id'));
			if ($productionItem != null)
				$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Info('info', $productionItem));
		}
		elseif ($this->getParam('type') == 'technology') {
			$productionItem = Rakuun_Intern_Production_Factory::getTechnology($this->getParam('id'));
			if ($productionItem != null)
				$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Info('info', $productionItem));
		}
		elseif ($this->getParam('type') == 'unit') {
			$productionItem = Rakuun_Intern_Production_Factory::getUnit($this->getParam('id'));
			if ($productionItem != null)
				$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Info('info', $productionItem));
		}
	}
}

?>