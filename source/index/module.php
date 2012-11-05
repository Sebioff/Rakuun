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
 * Parent module for all index-sites (all sites that are not ingame)
 */
class Rakuun_Index_Module extends Rakuun_Module {
	public function init() {
		parent::init();
		
		$this->mainPanel->setTemplate(dirname(__FILE__).'/main.tpl');
		$this->addCssRouteReference('css', 'index.css');
		$this->addJsRouteReference('js', 'ga.js');
		$this->setMetaTag('description', 'Bei dem kostenlosen SciFi-Browsergame Rakuun spielen mehrere Allianzen gegeneinander um den Sieg der Runde: den Bau eines gigantischen Raumschiffes.');
		$this->setMetaTag('keywords', 'browsergame, scifi, spielziel, strategie, weltraum');
		$navigation = new CMS_Navigation();
		$navigation->addNode(new CMS_Navigation_ModuleNode(App::get()->getIndexModule(), 'Home'));
		$navigation->addNode(new CMS_Navigation_ModuleNode(App::get()->getInfosModule(), 'Infos'));
		$navigation->addNode(new CMS_Navigation_ModuleNode(App::get()->getNewsModule(), 'News'));
		$navigation->addNode(new CMS_Navigation_ModuleNode(App::get()->getStoryModule(), 'Story'));
		$navigation->addNode(new CMS_Navigation_ModuleNode(App::get()->getScreenshotsModule(), 'Screenshots'));
		$this->mainPanel->params->navigation =  $navigation;
		Rakuun_GUI_Skinmanager::get()->setCurrentSkin('tech');
	}
}

?>