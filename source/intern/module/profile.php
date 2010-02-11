<?php

class Rakuun_Intern_Module_Profile extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Profil');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/profile.tpl');
		// add css files for all skins
		foreach (Rakuun_GUI_Skinmanager::get()->getAllSkins() as $skin) {
			foreach ($skin->getCssRouteReferences() as $route) {
				$this->addCssRouteReference($route[0], $route[1]);
			}
		}
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Profile_Edit('edit'));		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Profile_ChangePassword('change_password'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('delete', new Rakuun_Intern_GUI_Panel_Profile_Delete('link'), 'Account löschen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('options', new Rakuun_Intern_GUI_Panel_Profile_Options('options'), 'Optionen'));		
	}
}

?>