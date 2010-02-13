<?php

class Rakuun_Intern_Module_Statistics extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Statistik');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/statistics.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('statistics', new Rakuun_Intern_GUI_Panel_Statistics('statistics'), 'Statistik'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('military', new Rakuun_Intern_GUI_Panel_Statistics_Military('military'), 'Militär'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('economy', new Rakuun_Intern_GUI_Panel_Statistics_Economy('economy'), 'Wirtschaft'));
	}
}

?>