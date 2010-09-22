<?php

class Rakuun_Intern_Module_Meta_Edit extends Rakuun_Intern_Module_Meta_Common {
	public function init() {
		parent::init();

		$this->setPageTitle('Bearbeiten - '.$this->getUser()->alliance->meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/edit.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('edit', new Rakuun_Intern_GUI_Panel_Meta_Edit('edit'), 'Meta Details bearbeiten'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('kick', new Rakuun_Intern_GUI_Panel_Meta_Kick('kick'), 'Allianz kicken'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('mail', new Rakuun_Intern_GUI_Panel_Meta_Mail('mail', $this->getUser()->alliance->meta), 'Metarundmail schreiben'));
	}
}

?>