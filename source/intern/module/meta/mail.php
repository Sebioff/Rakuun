<?php

class Rakuun_Intern_Module_Meta_Mail extends Rakuun_Intern_Module_Meta_Navigation {
	public function init() {
		parent::init();

		$meta = $this->getUser()->alliance->meta;
		$this->setPageTitle('Rundmail - '.$meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/mail.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('mail', new Rakuun_Intern_GUI_Panel_Meta_Mail('mail', $meta), 'Metarundmail schreiben'));
	}
}

?>