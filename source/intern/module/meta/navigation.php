<?php

class Rakuun_Intern_Module_Meta_Navigation extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$navigation = new CMS_Navigation();
		$parent = App::get()->getInternModule()->getSubmodule('meta');
		$navigation->addModuleNode($parent, 'Übersicht');
		if ($parent->hasSubmodule('edit'))
			$navigation->addModuleNode($parent->getSubmodule('edit'), 'Details Bearbeiten');
		if ($parent->hasSubmodule('applications')) {
			$count = Rakuun_DB_Containers::getMetasApplicationsContainer()->countByMeta(Rakuun_User_Manager::getCurrentUser()->alliance->meta);
			$navigation->addModuleNode($parent->getSubmodule('applications'), 'Bewerbungen ('.$count.')');
		}
		if ($parent->hasSubmodule('kick'))
			$navigation->addModuleNode($parent->getSubmodule('kick'), 'Allianz kicken');
		if ($parent->hasSubmodule('board'))
			$navigation->addModuleNode($parent->getSubmodule('board'), 'Forum ('.Rakuun_Intern_GUI_Panel_Meta_Board::getNewPostingsCount().')');
		if ($parent->hasSubmodule('statistics'))
			$navigation->addModuleNode($parent->getSubmodule('statistics'), 'Statistiken');
		if ($parent->hasSubmodule('polls'))
			$navigation->addModuleNode($parent->getSubmodule('polls'), 'Umfragen');
		if ($parent->hasSubmodule('mail'))
			$navigation->addModuleNode($parent->getSubmodule('mail'), 'Rundmail schreiben');
		if ($parent->hasSubmodule('build'))
			$navigation->addModuleNode($parent->getSubmodule('build'), 'Meta-Gebäude');
		$this->contentPanel->params->navigation = $navigation;
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return (isset($user->alliance) && isset($user->alliance->meta));
	}
}

?>