<?php

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