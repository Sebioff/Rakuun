<?php

class Rakuun_Intern_Module_Alliance_Build extends Rakuun_Intern_Module_Alliance_Navigation implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Allianzgebäude bauen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/build.tpl');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP('wip', new Rakuun_Intern_Production_Producer_Alliances(Rakuun_User_Manager::getCurrentUser()->alliance), 'Momentaner Bauvorgang');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$canBuild = false;
		foreach (Rakuun_Intern_Production_Factory_Alliances::getAllBuildings() as $building) {
			if ($building->meetsTechnicalRequirements() || $building->getLevel() > 0) {
				$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Alliance('build_'.$building->getInternalName(), $building));
				$canBuild = true;
			}
		}
		if (!$canBuild) {
			$this->contentPanel->addPanel(new GUI_Panel_Text('information', 'Bauen derzeit nicht möglich - es wurden noch keine Vorraussetzungen für ein Allianzgebäude erfüllt.'));
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}

?>