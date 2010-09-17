<?php

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
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getIronRepayForAmount())).' Eisen'.
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getBerylliumRepayForAmount())).' Beryllium'.
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getEnergyRepayForAmount())).' Energie'.
				'\n'.GUI_Panel_Number::formatNumber(round($firstWIP->getPeopleRepayForAmount())).' Leute'
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