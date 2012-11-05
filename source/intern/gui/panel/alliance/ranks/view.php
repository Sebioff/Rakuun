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

class Rakuun_Intern_GUI_Panel_Alliance_Ranks_View extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/view.tpl');
	}
	
	public function beforeDisplay() {
		parent::beforeDisplay();
		
		$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		$groupsContainer = Rakuun_Intern_Alliance_Security::get()->getContainerGroups();
		$groups = $groupsContainer->selectByAlliance($alliance, array('order' => 'name ASC'));
		
		foreach ($groups as $group) {
			if ($group->groupIdentifier == Rakuun_Intern_Alliance_Security::GROUP_LEADERS
				&& !Rakuun_Intern_Alliance_Security::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::GROUP_LEADERS)
			)
				continue;
			
			$url = Router::get()->getCurrentModule()->getUrl(array('rank' => $group->getPK()));
			$this->addPanel(new GUI_Control_Link('group_'.$group->getPK(), Text::escapeHTML($group->name), $url));
		}
		
		if (!$groups)
			$this->addPanel(new GUI_Panel_Text('none', 'Keine Ränge vorhanden.'));
	}
}

?>