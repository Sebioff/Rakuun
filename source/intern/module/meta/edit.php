<?php

class Rakuun_Intern_Module_Meta_Edit extends Rakuun_Intern_Module_Meta_Navigation {
	public function init() {
		parent::init();

		$this->setPageTitle('Bearbeiten - '.$this->getUser()->alliance->meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/edit.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('edit', new Rakuun_Intern_GUI_Panel_Meta_Edit('Bearbeiten'), 'Meta Details bearbeiten'));
	}
}

?>