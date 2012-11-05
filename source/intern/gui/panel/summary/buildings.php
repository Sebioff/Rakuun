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

class Rakuun_Intern_GUI_Panel_Summary_Buildings extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/summary.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('summary'));
		$summe = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			if ($building->getLevel() > 0) {
				$table->addLine(
					array(
						new GUI_Control_Link('link'.$building->getInternalName(), $building->getName(), App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $building->getType(), 'id' => $building->getInternalName()))),
						Text::formatNumber($building->getLevel()),
						Text::formatNumber($building->getLevel() * $building->getPoints())
					)
				);
				$summe += $building->getLevel() * $building->getPoints();
			}
		}
		$table->addHeader(array('Name', 'Level', 'Punkte'));
		$table->addFooter(array('Summe:', '', Text::formatNumber($summe)));
		$table->addTableCssClass('align_left', 0);
	}
}
?>