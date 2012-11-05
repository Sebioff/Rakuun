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
 * Panel that is displayed if a meta starts the dancertia
 */
class Rakuun_Intern_GUI_Panel_Meta_DancertiaCountdown extends GUI_Panel {
	private $meta = null;
	
	public function __construct($name, Rakuun_DB_Meta $meta, $title = '') {
		parent::__construct($name, $title);
		$this->meta = $meta;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/dancertiacountdown.tpl');
		$this->addPanel($countdown = new Rakuun_GUI_Panel_CountDown('countdown', $this->getMeta()->dancertiaStarttime + RAKUUN_SPEED_DANCERTIA_STARTTIME, 'Gestartet!'));
		$countdown->enableHoverInfo(true);
		$this->params->currentShieldHolder = $this->meta->getCurrentShieldGeneratorHolder();
		$this->params->currentShieldCount = $this->meta->getShieldGeneratorCount();
		$this->addPanel($userlink = new Rakuun_GUI_Control_UserLink('userlink', $this->meta->getCurrentShieldGeneratorHolder()));
		$this->addPanel($metalink = new Rakuun_GUI_Control_MetaLink('metalink', $this->meta));
		
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_Meta
	 */
	public function getMeta() {
		return $this->meta;
	}
}

?>