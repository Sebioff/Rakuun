<?php

class Rakuun_Intern_Module_Alliance_Diplomacy extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$this->setPageTitle('Diplomatie - ['.$this->getUser()->alliance->tag.'] '.$this->getUser()->alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/diplomacy.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('offers', new Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_Offers('offers'), 'Diplomatieangebote'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('actives', new Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_Actives('actives'), 'Bestehende Verträge'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('newoffer', new Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_NewOffer('newoffer'), 'Diplomatieangebot erstellen'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Mode::getCurrentMode()->allowDiplomacy() && Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_DIPLOMACY);
	}
}

?>