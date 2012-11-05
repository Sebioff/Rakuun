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

class Rakuun_Intern_Module_Support_Display extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$id = (int)$this->getParam('id');
		$supportticket = Rakuun_DB_Containers::getSupportticketsContainer()->selectByPK($id);
		if (!$supportticket) {
			$this->redirect($this->getParent()->getUrl());
		}
		
		$this->setPageTitle('Nachricht');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/display.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_Categories('categories', 'Nachrichtenkategorien'));
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_Ticket('supportticket', $supportticket));
		if ($supportticket) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('answer', new Rakuun_Intern_GUI_Panel_Support_Answer('answer', $supportticket)), 'Antwort schreiben');
		}
	}
}

?>