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
 * Views all available unasnwered Tickets for a category
 */
class Rakuun_Intern_GUI_Panel_Support_View extends GUI_Panel_PageView {
	private $supportticketsContainer = null;
	private $envelopes = array();
	private $category;
	
	public function __construct($name, $messageType = Rakuun_Intern_IGM::TYPE_PRIVATE) {
		$filter = array();
		if (array_key_exists($messageType, Rakuun_Intern_Support_Ticket::getMessageTypes())) {
			$filter['conditions'][] = array('is_answered = ?', false);
			$filter['conditions'][] = array('type = ?', $messageType);
		}
		else {
			$filter = DB_Container::mergeOptions($filter, Rakuun_Intern_GUI_Panel_Support_Categories::getOptionsForCategory($messageType));
		}
		$this->supportticketsContainer = Rakuun_DB_Containers::getSupportticketsContainer()->getFilteredContainer($filter);
		
		$this->category = $messageType;
		parent::__construct($name, $this->supportticketsContainer, '');
	}
	
	public function init() {
		parent::init();
		
		$filterOptions = $this->getOptions();
		$filterOptions['order'] = 'id DESC';
		foreach ($this->getSupportticketsContainer()->select($filterOptions) as $ticket) {
			$this->addEnvelope(new Rakuun_Intern_GUI_Panel_Support_Envelope('ticket_'.$ticket->getPK(), $ticket));
		}
		
		$this->setTemplate(dirname(__FILE__).'/view.tpl');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getEnvelopes() {
		return $this->envelopes;
	}
	
	public function getSupportticketsContainer() {
		return $this->supportticketsContainer;
	}
	
	public function addEnvelope(Rakuun_Intern_GUI_Panel_Support_Envelope $envelope) {
		$this->addPanel($envelope);
		$this->envelopes[] = $envelope;
	}
}

?>