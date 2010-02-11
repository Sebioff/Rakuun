<?php

class Rakuun_Index_Panel_Login extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/login.tpl');
		
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->setFocus();
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		// captcha is annoying in development environment
		if (Environment::getCurrentEnvironment() != Environment::DEVELOPMENT)
			$this->addPanel(new GUI_Control_Captcha('captcha', 'Code'));
		$this->addPanel(new GUI_Control_HiddenBox('base64'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Login'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$module = Router::get()->getCurrentModule();
		$module->addJsRouteReference('core_js', 'base64.js');
		$module->addJsAfterContent(sprintf('var string = base64.encode(screen.width + " * " + screen.height + ", " + screen.colorDepth); $("#%s").val(string);', $this->base64->getID()));
	}
	
	public function onSubmit() {
		$user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->username);
		
		if ($loginError = Rakuun_User_Manager::login($this->username->getValue(), $this->password->getValue()))
			$this->addError($loginError);
		
		if ($this->hasErrors())
			return;
			
		Rakuun_Intern_Log_UserActivity::log($user, Rakuun_Intern_Log::ACTION_ACTIVITY_LOGIN, base64_decode($this->base64->getValue()));
		// set cookie for tracking players on this pc (needs to be done after logging)
		setcookie('data', $user->nameUncolored, time() + 60 * 60 * 24 * 356 * 5);
		
		$this->setTemplate(dirname(__FILE__).'/login_successful.tpl');
		
		$redirectUrl = App::get()->getInternModule()->getSubmoduleByName('overview')->getUrl();
		if ($this->getModule()->getParam('return') !== null)
			$redirectUrl = base64_decode($this->getModule()->getParam('return'));
		Router::get()->getCurrentModule()->jsRedirect($redirectUrl, 1000);
	}
}

?>