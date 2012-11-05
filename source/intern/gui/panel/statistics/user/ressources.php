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

class Rakuun_Intern_GUI_Panel_Statistics_User_Ressources extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/ressources.tpl');
		
		$this->addPanel($capturedTable = new GUI_Panel_Table('captured_statistics'));
		$capturedTable->addHeader(array('Ressource', 'Anzahl'));
		
		$options = array();
		$options['properties'] = 'SUM(iron) as iron, SUM(beryllium) as beryllium, SUM(energy) as energy';
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('action = ?', Rakuun_Intern_Log::ACTION_RESSOURCES_FIGHT);
		$capturedRessources = Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->selectFirst($options);
		
		$capturedTable->addLine(array('Eisen', Text::formatNumber($capturedRessources->iron)));
		$capturedTable->addLine(array('Beryllium', Text::formatNumber($capturedRessources->beryllium)));
		$capturedTable->addLine(array('Energie', Text::formatNumber($capturedRessources->energy)));
		$capturedTable->addTableCssClass('align_left', 0);
		
		$this->addPanel($lostTable = new GUI_Panel_Table('lost_statistics'));
		$lostTable->addHeader(array('Ressource', 'Anzahl'));
		
		$options = array();
		$options['properties'] = 'SUM(iron) as iron, SUM(beryllium) as beryllium, SUM(energy) as energy';
		$options['conditions'][] = array('sender = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('action = ?', Rakuun_Intern_Log::ACTION_RESSOURCES_FIGHT);
		$lostRessources = Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->selectFirst($options);
		
		$lostTable->addLine(array('Eisen', Text::formatNumber($lostRessources->iron)));
		$lostTable->addLine(array('Beryllium', Text::formatNumber($lostRessources->beryllium)));
		$lostTable->addLine(array('Energie', Text::formatNumber($lostRessources->energy)));
		$lostTable->addTableCssClass('align_left', 0);
	}
}

?>