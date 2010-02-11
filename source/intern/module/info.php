<?php

/**
 * Displays information about units, buildings, technologies or users
 */
class Rakuun_Intern_Module_Info extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Info');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/info.tpl');
		
		if ($this->getParam('type') == 'building') {
			$productionItem = Rakuun_Intern_Production_Factory::getBuilding($this->getParam('id'));
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Info('info', $productionItem));
		}
		elseif ($this->getParam('type') == 'technology') {
			$productionItem = Rakuun_Intern_Production_Factory::getTechnology($this->getParam('id'));
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Info('info', $productionItem));
		}
		elseif ($this->getParam('type') == 'unit') {
			$productionItem = Rakuun_Intern_Production_Factory::getUnit($this->getParam('id'));
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Info('info', $productionItem));
		}
	}
}

?>