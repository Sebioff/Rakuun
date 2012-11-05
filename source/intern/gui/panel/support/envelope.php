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
class Rakuun_Intern_GUI_Panel_Support_Envelope extends GUI_Panel {
	private $supportticket = null;
	
	public function __construct($name, DB_Record $supportticket) {
		parent::__construct($name, '');
		
		$this->supportticket = $supportticket;
		$this->addClasses('rakuun_message_envelope');
		if (!$this->supportticket->isAnswered)
			$this->addClasses('rakuun_message_unread');
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/envelope.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->supportticket->time, 'Datum'));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('user', $this->supportticket->user, $this->supportticket->get('user'), 'User'));
		$this->params->url = App::get()->getInternModule()->getSubmodule('support')->getSubmodule('display')->getURL(array('id' => $this->getTicket()->getPK()));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getTicket() {
		return $this->supportticket;
	}
}

?>