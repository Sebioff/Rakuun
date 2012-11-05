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

class Rakuun_Intern_Module_Highscores extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Highscores');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/highscores.tpl');
		$this->contentPanel->addPanel($userHighscore = new Rakuun_GUI_Panel_Box('userbox', new Rakuun_Intern_GUI_Panel_User_Highscore('userhighscore', Rakuun_DB_Containers::getUserContainer()), 'User Highscore'));
		$userHighscore->addClasses('rakuun_userhighscore');
		$this->contentPanel->addPanel($allianceHighscore = new Rakuun_GUI_Panel_Box('alliancebox', new Rakuun_Intern_GUI_Panel_Alliance_Highscore('alliancehighscore', Rakuun_DB_Containers::getAlliancesContainer()), 'Allianz Highscore'));
		$allianceHighscore->addClasses('rakuun_alliancehighscore');
		$this->contentPanel->addPanel($quests = new Rakuun_GUI_Panel_Box('quests', new Rakuun_Intern_GUI_Panel_User_QuestLog('quests'), 'Quests'));
		$quests->addClasses('rakuun_questbox');
	}
}

?>