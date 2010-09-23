<?php

class Rakuun_Index_Module_Story extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Story');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/story.tpl');
		$this->setMetaTag('description', 'Steige in die Welt des kostenlosen SciFi-Browsergames Rakuun ein und kämpfe um die Herrschaft über den Planeten und den Bau eines gigantischen Raumschiffes!');
		$this->setMetaTag('keywords', 'browsergame, scifi, story');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('story', new Rakuun_Index_Panel_Story('content'), 'Story'));
	}
}

?>