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

class Rakuun_Index_Module_Index extends Rakuun_Index_Module {
	public function onConstruct() {
		parent::onConstruct();
		
		$this->setRouteName('');
	}
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Runde '.RAKUUN_ROUND_NAME);
		$this->setMetaTag('google-site-verification', 'eIrItgI6k6mLi528ji-izDF1xubnjvqa3QYJABicHMo');
		$this->setMetaTag('og:title', 'Rakuun, das SciFi-Browsergame');
		$this->setMetaTag('og:type', 'website');
		$this->setMetaTag('og:image', 'http://www.rakuun.de/Rakuun/www/images/logo_80x80.jpg');
		$this->setMetaTag('og:url', 'http://www.rakuun.de');
		$this->setMetaTag('og:site_name', 'Rakuun');
		$this->setMetaTag('og:app_id', '');
		
		if (date('d.m') == '31.12')
			$this->addJsRouteReference('js', '/seasons/newyear.js');
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/index.tpl');
		$this->contentPanel->addPanel($infobox = new Rakuun_GUI_Panel_Box('serverinfo', new Rakuun_Index_Panel_Serverinfo('content'), 'Serverinfo - Runde '.RAKUUN_ROUND_NAME));
		$this->contentPanel->addPanel($registerBox = new Rakuun_GUI_Panel_Box('register', new Rakuun_Index_Panel_Register('content'), 'Schnellregistrierung'));
		$registerBox->addClasses('rakuun_box_register');
		if (!Rakuun_Game::isLoginDisabled()) {
			$this->contentPanel->addPanel($loginBox = new Rakuun_GUI_Panel_Box('login', new Rakuun_Index_Panel_Login('login'), 'Login'));
			$loginBox->addClasses('rakuun_box_login');
		}
		
		if ($logoutReason = $this->getParam('logout-reason')) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box_Note('logout_reason', $logoutReasonText = new GUI_Panel_Text('logout_reason', '', 'Ausgeloggt'), 'Ausgeloggt'));
			switch ($logoutReason) {
				case 'noactivity':
					$logoutReasonText->setText('Du wurdest sicherheitshalber automatisch ausgeloggt, da du für mindestens '.Rakuun_Date::formatCountDown(Rakuun_Intern_Module::TIMEOUT_NOACTIVITY).' keine Aktionen durchgeführt hast.');
				case 'notloggedin':
					$logoutReasonText->setText('Du musst dich erst einloggen, um Zugang zu dieser Seite zu haben.');
				break;
			}
		}
	}
}

?>