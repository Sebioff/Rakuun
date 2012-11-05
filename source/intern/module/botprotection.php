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