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

class Rakuun_Intern_GUI_Panel_Statistics_User_Fights extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/fights.tpl');
		
		$this->addPanel($wonTable = new GUI_Panel_Table('won_statistics'));
		$wonTable->addHeader(array('Angriff', 'Verteidigung'));
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_WON);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_ATTACKER);
		$wonAttack = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_WON);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_DEFENDER);
		$wonDefense = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		
		$wonTable->addLine(array(Text::formatNumber($wonAttack), Text::formatNumber($wonDefense)));
		$wonTable->addTableCssClass('align_left', 0);
		
		$this->addPanel($lostTable = new GUI_Panel_Table('lost_statistics'));
		$lostTable->addHeader(array('Angriff', 'Verteidigung'));
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_LOST);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_ATTACKER);
		$lostAttack = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_LOST);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_DEFENDER);
		$lostDefense = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		
		$lostTable->addLine(array(Text::formatNumber($lostAttack), Text::formatNumber($lostDefense)));
		$lostTable->addTableCssClass('align_left', 0);
	}
}

?>
