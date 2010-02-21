<?php

class Rakuun_Intern_Module_Meta_Build extends Rakuun_Intern_Module_Meta_Navigation implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Metagebäude bauen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/build.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Alliance('wip', new Rakuun_Intern_Production_Producer_Metas(Rakuun_User_Manager::getCurrentUser()->alliance->meta), 'Momentaner Bauvorgang');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$canBuild = false;
		foreach (Rakuun_Intern_Production_Factory_Metas::getAllBuildings() as $building) {
			if ($building->meetsTechnicalRequirements() || $building->getLevel() > 0) {
				$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Meta('build_'.$building->getInternalName(), $building));
				$canBuild = true;
			}
		}
		if (!$canBuild) {
			$this->contentPanel->addPanel(new GUI_Panel_Text('information', 'Bauen derzeit nicht möglich - es wurden noch keine Vorraussetzungen für ein Metagebäude erfüllt.'));
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance->meta));
	}
}

?>