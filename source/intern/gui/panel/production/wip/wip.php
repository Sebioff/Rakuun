<?php

class Rakuun_Intern_GUI_Panel_Production_WIP extends Rakuun_GUI_Panel_Box {
	protected $producer = null;
	protected $enableQueueView = true;
		
	public function __construct($name, Rakuun_Intern_Production_Producer $producer, $title = '') {
		parent::__construct($name, null, $title);
		
		$this->producer = $producer;
		//$this->producer->getItemWIPContainer()->addInsertCallback(array($this, 'addWIPItem'));
		
		// checking if there are WIPs, since after produce() it might have changed
		if ($wip = $this->producer->getWIP()) {
			$this->contentPanel->addPanel($countDown = new Rakuun_GUI_Panel_CountDown('countdown', $wip[0]->getTargetTime(), 'Fertiggestellt.'));
			if (Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Overview) {
				// FIXME evil, hardcoded panel ids
				$countDown->setJSCallback(sprintf('function (){$.core.refreshPanels(["%s", "%s", "%s", "%s"]);}', 'main-overview_content-wip_buildings', 'main-overview_content-buildings', 'main-overview_content-wip_technologies', 'main-overview_content-technologies'));
			}
			else {
				$countDown->setJSCallback('function (){window.location.assign(location.href)}');
			}
			$countDown->enableHoverInfo(true);
		}
		
		$i = 0;
		$wipItemsCount = count($this->getProducer()->getWIP());
		foreach ($this->getProducer()->getWIP() as $wipPanel) {
			if ($i <= 1)
				$wipPanel->removePanel($wipPanel->moveUp);
			if ($i >= $wipItemsCount - 1)
				$wipPanel->removePanel($wipPanel->moveDown);
			$this->addPanel($wipPanel);
			$i++;
		}
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/wip.tpl');
	}
	
	public function display() {
		if ($this->producer->getWIP())
			parent::display();
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_Intern_Production_Producer
	 */
	public function getProducer() {
		return $this->producer;
	}
	
	public function enableQueueView($value = true) {
		$this->enableQueueView = $value;
	}
	
	public function getEnableQueueView() {
		return $this->enableQueueView;
	}
}

?>