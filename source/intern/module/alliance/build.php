<?php

class Rakuun_Intern_Module_Alliance_Build extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Allianzgebäude bauen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/build.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Alliance('wip', new Rakuun_Intern_Production_Producer_Alliances(Rakuun_User_Manager::getCurrentUser()->alliance), 'Momentaner Bauvorgang');
		$this->contentPanel->addPanel($wipPanel, true);
		
		foreach (Rakuun_Intern_Production_Factory_Alliances::getAllBuildings() as $building) {
			$this->contentPanel->addPanel($itemBox = new Rakuun_GUI_Panel_Box('build_'.$building->getInternalName(), new Rakuun_Intern_GUI_Panel_Production_Alliance('build_'.$building->getInternalName(), $building)));
			$itemBox->addClasses('production_item_box');
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}

?>