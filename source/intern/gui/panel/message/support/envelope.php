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
 * Panel displaying the "envelope" of a ticket -> short information
 */
class Rakuun_Intern_GUI_Panel_Message_Support_Envelope extends Rakuun_Intern_GUI_Panel_Message_Envelope {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/envelope.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->getMessage()->time, 'Datum'));
		$this->addPanel(new GUI_Panel_Text('supporter', $this->getMessage()->supporter ? $this->getMessage()->supporter->name : 'kein Supporter', 'Supporter'));
		$this->params->url = App::get()->getInternModule()->getSubmodule('messages')->getSubmodule('display')->getURL(array('ticketID' => $this->getMessage()->getPK()));
	}
}

?>