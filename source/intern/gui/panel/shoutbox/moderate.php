<?php

class Rakuun_Intern_GUI_Panel_Shoutbox_Moderate extends GUI_Panel {
	const TIMEBAN_LENGTH = 10800; //3h
	
	protected $config = null;
	protected $shout = null;
	
	public function __construct($name, Shoutbox_Config $config, DB_Record $shout, $title = '') {
		$this->config = $config;
		$this->shout = $shout;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/moderate.tpl');
		
		$module = $this->getModule();
		$this->addPanel($deleteLink = new GUI_Control_Link('delete', '-Löschen-', $module->getUrl(array('moderate' => Rakuun_User_Manager::getCurrentUser()->getPK(), 'delete' => $this->shout->getPK()))));
		$deleteLink->setConfirmationMessage('Diesen Post wirklich löschen?');
		if ($this->config->getIsGlobal()) {
			$this->addPanel($timebanLink = new GUI_Control_Link('timeban', '-Timeban-', $module->getUrl(array('moderate' => Rakuun_User_Manager::getCurrentUser()->getPK(), 'timeban' => $this->shout->getPK()))));
			$timebanLink->setConfirmationMessage('Diesen User wirklich für '.Rakuun_Date::formatCountDown(self::TIMEBAN_LENGTH).' bannen?');
		}
		
		if ($module->getParam('moderate') == Rakuun_User_Manager::getCurrentUser()->getPK()) {
			// delete post
			if ($module->getParam('delete') == $this->shout->getPK()) {
				$this->shout->delete();
				$this->getModule()->invalidate();
			}
				
			// timeban user
			if ($this->config->getIsGlobal() && $module->getParam('timeban') == $this->shout->getPK()) {
				$this->shout->user->shoutboxTimeban = time();
				$this->shout->user->save();
				$igm = new Rakuun_Intern_IGM('Shoutbox Ban', $this->shout->user);
				$igm->setText('
					Hallo '.$this->shout->user->nameUncolored.',
					Du wurdest gerade von '.Rakuun_User_Manager::getCurrentUser()->nameUncolored.' für '.Rakuun_Date::formatCountDown(self::TIMEBAN_LENGTH).'
					aus der Shoutbox gebannt.
				');
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
				$igm->send();
			}
		}
	}
}
?>