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

class Rakuun_Intern_GUI_Panel_Summary_Technologies extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/summary.tpl');
		
		$table = new GUI_Panel_Table('summary');
		$summe = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if ($technology->getLevel() > 0) {
				$table->addLine(
					array(
						new GUI_Control_Link('link'.$technology->getInternalName(), $technology->getName(), App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $technology->getType(), 'id' => $technology->getInternalName()))),
						Text::formatNumber($technology->getLevel()),
						Text::formatNumber($technology->getLevel() * $technology->getPoints())
					)
				);
				$summe += $technology->getLevel() * $technology->getPoints();
			}
		}
		if (count($table->getLines()) == 0)
			$this->addPanel(new GUI_Panel_Text('summary', 'Keine.'));
		else {
			$table->addHeader(array('Name', 'Level', 'Punkte'));
			$table->addFooter(array('Summe:', '', Text::formatNumber($summe)));
			$this->addPanel($table);
		}
		$table->addTableCssClass('align_left', 0);
	}
}
?>