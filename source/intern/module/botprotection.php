<?php

/**
 * Module to keep bots out.
 */
class Rakuun_Intern_Module_BotProtection extends Rakuun_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Bot or not?');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/botprotection.tpl');
		
		$this->contentPanel->addPanel(new GUI_Control_Captcha('captcha', 'Code'));
		$this->contentPanel->addPanel(new GUI_Control_SubmitButton('submit', 'OK'));
	}
	
	public function onSubmit() {
		if ($this->contentPanel->hasErrors())
			return;
			
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->lastBotVerification = time();
		Rakuun_User_Manager::update($user);
		
		$redirectUrl = App::get()->getInternModule()->getSubmoduleByName('overview')->getUrl();
		if ($this->getParam('return') !== null)
			$redirectUrl = base64_decode($this->getParam('return'));
		Scriptlet::redirect($redirectUrl);
	}
}

?>