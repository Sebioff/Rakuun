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
		if (!Rakuun_Game::isLoginDisabled()) {
			$this->addPanel($testaccountLogin = new GUI_Control_Link('testaccount_login', 'Test-Account', App::get()->getInternModule()->getSubmodule('overview')->getUrl(array('login' => 'testaccount'))));
			$testaccountLogin->addClasses('rakuun_testaccount_login', 'core_gui_button_highlighted');
		}
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$module = Router::get()->getCurrentModule();
		$module->addJsRouteReference('core_js', 'base64.js');
		$module->addJsAfterContent(sprintf('var string = base64.encode(screen.width + " * " + screen.height + ", " + screen.colorDepth); $("#%s").val(string);', $this->base64->getID()));
	}
	
	public function onSubmit() {
		if ($loginError = Rakuun_User_Manager::login($this->username->getValue(), $this->password->getValue()))
			$this->addError($loginError);
		
		if ($this->hasErrors())
			return;
			
		$user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->username);
		Rakuun_Intern_Log_UserActivity::log($user, Rakuun_Intern_Log::ACTION_ACTIVITY_LOGIN, base64_decode($this->base64->getValue()));
		// set cookie for tracking players on this pc (needs to be done after logging)
		setcookie('data', $user->nameUncolored, time() + 60 * 60 * 24 * 356 * 5);
		
		$this->setTemplate(dirname(__FILE__).'/login_successful.tpl');
		
		$redirectUrl = App::get()->getInternModule()->getSubmoduleByName('overview')->getUrl();
		if ($this->getModule()->getParam('return') !== null)
			$redirectUrl = base64_decode($this->getModule()->getParam('return'));
		$this->addPanel($continueLink = new GUI_Control_Link('continue_link', 'Weiter...', $redirectUrl));
		$continueLink->addClasses('login_successful_continue_link');
		Router::get()->getCurrentModule()->addJsAfterContent(sprintf('$(".login_successful_continue_link").hide();'));
		Router::get()->getCurrentModule()->jsRedirect($redirectUrl, 1000);
	}
}

?>