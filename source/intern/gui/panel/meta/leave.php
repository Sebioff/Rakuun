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
 * Panel which displays a button to leave a meta.
 */
class Rakuun_Intern_GUI_Panel_Meta_Leave extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/leave.tpl');
		$this->addPanel($button = new GUI_Control_SecureSubmitButton('leave', 'Verlassen'));
		$button->setConfirmationMessage('Wollt ihr die Meta wirklich verlassen?');
	}
	
	public function onLeave() {
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		if (Rakuun_DB_Containers::getAlliancesContainer()->countByMeta($alliance->meta) == 1) {
			//delete meta after last alliance left
			Rakuun_DB_Containers::getMetasContainer()->delete($alliance->meta);
		}
		$alliance->meta = null;
		Rakuun_DB_Containers::getAlliancesContainer()->save($alliance);
		DB_Connection::get()->commit();
		$this->getModule()->redirect(App::get()->getInternModule()->getURL());
	}
}

?>