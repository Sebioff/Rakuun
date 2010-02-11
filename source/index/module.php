<?php

/**
 * Parent module for all index-sites (all sites that are not ingame)
 */
class Rakuun_Index_Module extends Rakuun_Module {
	public function init() {
		parent::init();
		
		Rakuun_GUI_Skinmanager::get()->setCurrentSkin('tech');
		$this->mainPanel->setTemplate(dirname(__FILE__).'/main.tpl');
		$this->addCssRouteReference('css', 'index.css');
		$this->setMetaTag('description', 'Bei dem kostenlosen SciFi-Browsergame Rakuun spielen mehrere Allianzen gegeneinander um den Sieg der Runde: den Bau eines gigantischen Raumschiffes.');
		$this->setMetaTag('keywords', 'browsergame, scifi, spielziel, strategie');
		// add skin-specific css files
		foreach (Rakuun_GUI_Skinmanager::get()->getCssRouteReferences() as $route) {
			$this->addCssRouteReference($route[0], $route[1]);
		}
		$navigation = new CMS_Navigation();
		$navigation->addModuleNode(App::get()->getIndexModule(), 'Home');
		$navigation->addModuleNode(App::get()->getRegisterModule(), 'Anmelden');
		$navigation->addModuleNode(App::get()->getLoginModule(), 'Login');
		$this->mainPanel->params->navigation =  $navigation;
	}
}

?>