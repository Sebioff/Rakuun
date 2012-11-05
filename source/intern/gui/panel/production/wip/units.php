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

class Rakuun_Intern_GUI_Panel_Production_WIP_Units extends Rakuun_Intern_GUI_Panel_Production_WIP {
	public function __construct($name, Rakuun_Intern_Production_Producer_Units $producer, $title = '') {
		parent::__construct($name, $producer, $title);
		
		if ($wip = $this->getProducer()->getWIP()) {
			$this->contentPanel->countdown->setJSCallback('null');
			$this->contentPanel->addPanel($countDownTotal = new Rakuun_GUI_Panel_CountDown('countdown_total', $wip[0]->getTotalTargetTime()));
			$countDownTotal->enableHoverInfo(true);
		}
		
		$wipItems = $this->getProducer()->getWIP();
		if ($wipItems) {
			$firstWIP = $wipItems[0];
			$this->contentPanel->cancel->setConfirmationMessage(
				'Wirklich abbrechen?\nEs werden 50% der Kosten erstattet:'.
				'\n'.Text::formatNumber(round($firstWIP->getIronRepayForAmount())).' Eisen'.
				'\n'.Text::formatNumber(round($firstWIP->getBerylliumRepayForAmount())).' Beryllium'.
				'\n'.Text::formatNumber(round($firstWIP->getEnergyRepayForAmount())).' Energie'.
				'\n'.Text::formatNumber(round($firstWIP->getPeopleRepayForAmount())).' Leute'
			);
		}
		
		$this->contentPanel->addPanel($pauseButton = new GUI_Control_SubmitButton('pause', 'Pausieren'));
		$pauseButton->addClasses('rakuun_btn_pause');
		if (Rakuun_User_Manager::getCurrentUser()->productionPaused)
			$pauseButton->setValue('Fortsetzen');
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/units.tpl');
	}
	
	public function init() {
		parent::init();
		
		if ($this->contentPanel->hasPanel('countdown')) {
			$countDown = $this->contentPanel->countdown;
			if (Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Overview) {
				// FIXME evil, hardcoded panel id
				$countDown->setJSCallback(sprintf('function (){$.core.refreshPanels(["%s", "%s"]);}', $this->getID(), 'main-overview_content-units'));
			}
			else {
				$countDown->setJSCallback(sprintf('function (){$.core.refreshPanels(["%s"]);}', $this->getID()));
			}
		}
		
		if ($this->contentPanel->hasPanel('countdown_total')) {
			$countDownTotal = $this->contentPanel->countdownTotal;
			if (Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Overview) {
				// FIXME evil, hardcoded panel id
				$countDownTotal->setJSCallback(sprintf('function (){$.core.refreshPanels(["%s", "%s"]);}', $this->getID(), 'main-overview_content-units'));
			}
			else {
				$countDownTotal->setJSCallback('function (){window.location.assign(location.href)}');
			}
		}
	}
	
	public function onPause() {
		$user = Rakuun_User_Manager::getCurrentUser();
		
		if (Rakuun_User_Manager::getCurrentUser()->productionPaused) {
			$wipContainer = Rakuun_DB_Containers::getUnitsWIPContainer();
			// TODO urgh, hard-coded query
			$query = 'UPDATE `'.$wipContainer->getTable().'` SET starttime = '.time().' WHERE user = \''.$user->getPK().'\'';
			$wipContainer->update($query);
			$user->productionPaused = 0;
		}
		else {
			$user->productionPaused = time();
		}
		
		Rakuun_User_Manager::update($user);
		Router::get()->getCurrentModule()->invalidate();
	}
}

?>