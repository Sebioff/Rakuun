<?php

class Rakuun_Intern_Module_Build_Workers extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Arbeiter verwalten');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/workers.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_ironmine', Rakuun_Intern_Production_Factory::getBuilding('ironmine')));
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_berylliummine', Rakuun_Intern_Production_Factory::getBuilding('berylliummine')));
		if (Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getLevel() > 0)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_clonomat', Rakuun_Intern_Production_Factory::getBuilding('clonomat')));
		if (Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getLevel() > 0)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_hydropower_plant', Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')));
	}
}

?>