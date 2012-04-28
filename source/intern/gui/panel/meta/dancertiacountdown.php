<?php

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