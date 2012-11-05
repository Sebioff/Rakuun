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

class Rakuun_GUI_Panel_CountDown extends GUI_Panel {
	private $finishedMessage = '';
	private $jsCallback = 'null';
	private $targetTime = 0;
	private $enableHoverInfo = false;
	
	public function __construct($name, $targetTime, $finishedMessage = '', $title = '') {
		parent::__construct($name, $targetTime, $title);
		
		$this->targetTime = $targetTime;
		$this->setFinishedMessage($finishedMessage);
		$this->setTemplate(dirname(__FILE__).'/countdown.tpl');
		$this->addClasses('rakuun_countdown');
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getValue() {
		if ($this->getTargetTime() <= time() && $this->getFinishedMessage())
			return $this->getFinishedMessage();
		else
			return Rakuun_Date::formatCountDown($this->getTargetTime() - time());
	}
	
	public function enableHoverInfo($enableHoverInfo) {
		$this->enableHoverInfo = $enableHoverInfo;
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function init() {
		parent::init();
		
		$currentModule = Router::get()->getCurrentModule();
		$currentModule->addJsRouteReference('js', 'panel/countdown.js');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->addJS(sprintf('new GUI_Control_CountDown("%s", "%d", "%d", "%d", "%s", %s);', $this->getID(), time(), $this->getTargetTime(), $this->enableHoverInfo, $this->getFinishedMessage(), $this->getJSCallback()));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getFinishedMessage() {
		return $this->finishedMessage;
	}
	
	public function setFinishedMessage($finishedMessage) {
		$this->finishedMessage = $finishedMessage;
	}
	
	public function getJSCallback() {
		return $this->jsCallback;
	}
	
	public function setJSCallback($jsCallback) {
		$this->jsCallback = $jsCallback;
	}
	
	public function getTargetTime() {
		return $this->targetTime;
	}
}

?>