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
 * Panel to edit alliance details
 */
class Rakuun_Intern_GUI_Panel_Alliance_Internbox extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->setTemplate(dirname(__FILE__).'/internbox.tpl');
		$this->addPanel(new GUI_Panel_Text('text', Rakuun_Text::formatPlayerText($user->alliance->intern, false)), 'Interne Informationen');
		$allianceModule = App::get()->getInternModule()->getSubmoduleByName('alliance');
		if ($allianceModule->hasSubmodule('edit'))
			$this->addPanel(new GUI_Control_Link('edit', "bearbeiten", $allianceModule->getSubmoduleByName('edit')->getUrl()));
	}
}

?>