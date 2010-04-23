<?php

class Rakuun_Intern_Module_Boards_Navigation extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$navigation = new CMS_Navigation();
		$parent = App::get()->getInternModule()->getSubmodule('boards');
		$user = Rakuun_User_Manager::getCurrentUser();
		$navigation->addModuleNode($parent, 'Überblick');
		if ($parent->hasSubmodule('global')) {
			$navigation->addModuleNode($parent->getSubmodule('global'), 'Allgemein');
		}
		if ($parent->hasSubmodule('alliance')) {
			$navigation->addModuleNode($parent->getSubmodule('alliance'), 'Allianz');
		}
		if ($parent->hasSubmodule('meta')) {
			$navigation->addModuleNode($parent->getSubmodule('meta'), 'Meta');
		}
		if ($parent->hasSubmodule('admin')) {
			$navigation->addModuleNode($parent->getSubmodule('admin'), 'Admin');
		}
		$this->contentPanel->params->navigation = $navigation;
	}
	
	public function setPageTitle($title) {
		parent::setPageTitle('Foren - '.$title);
	}
}
?>