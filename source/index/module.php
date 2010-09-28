<?php

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
		$navigation->addModuleNode(App::get()->getIndexModule(), 'Home');
		$navigation->addModuleNode(App::get()->getInfoModule(), 'Infos');
		$navigation->addModuleNode(App::get()->getNewsModule(), 'News');
		$navigation->addModuleNode(App::get()->getStoryModule(), 'Story');
		//$navigation->addModuleNode(App::get()->getScreenshotsModule(), 'Screenshots');
		$this->mainPanel->params->navigation =  $navigation;
	}
}

?>