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

class Rakuun_Intern_GUI_Panel_Alliance_Profile_None extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->getModule()->setPageTitle('Allianz');
		$this->setTemplate(dirname(__FILE__).'/none.tpl');
		
		$this->addPanel(new Rakuun_GUI_Panel_Box('search', new Rakuun_Intern_GUI_Panel_Alliance_Search('search'), 'Allianz suchen'));
		if (Rakuun_Intern_Mode::getCurrentMode()->allowFoundAlliances())
			$this->addPanel(new Rakuun_GUI_Panel_Box('found', new Rakuun_Intern_GUI_Panel_Alliance_Found('found', Rakuun_Intern_Module_Alliance_Profile_Own::FOUNDINGCOSTS_IRON, Rakuun_Intern_Module_Alliance_Profile_Own::FOUNDINGCOSTS_BERYLLIUM), 'Allianz gründen'));
	}
}
?>