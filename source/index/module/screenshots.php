<?php

class Rakuun_Index_Module_Screenshots extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Screenshots');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/screenshots.tpl');
		$this->setMetaTag('description', 'Screenshots von Rakuun, dem kostenlosen SciFi-Browsergame');
		$this->setMetaTag('keywords', 'weltraum, screenshots, bilder, spiel');
		$this->addCssRouteReference('css', 'panel/lightbox/lightbox.css');
		$this->addJsRouteReference('js', 'panel/lightbox/jquery.lightbox.js');
		$this->addJsAfterContent('
			$(".lightbox").lightbox({
			    fitToScreen: true,
			    imageClickClose: false
		    });
		');
	}
}

?>