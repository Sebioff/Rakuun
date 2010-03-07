<?php

class Rakuun_Intern_Module_Alliance_Navigation extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$navigation = new CMS_Navigation();
		$parent = App::get()->getInternModule()->getSubmodule('alliance');
		if (isset($this->getUser()->alliance))
			$navigation->addModuleNode($parent, 'Übersicht');
		if ($parent->hasSubmodule('members'))
			$navigation->addModuleNode($parent->getSubmodule('members'), 'Mitglieder');
		if ($parent->hasSubmodule('edit'))
			$navigation->addModuleNode($parent->getSubmodule('edit'), 'Beschreibung bearbeiten');
		if ($parent->hasSubmodule('ranks'))
			$navigation->addModuleNode($parent->getSubmodule('ranks'), 'Ränge');
		if ($parent->hasSubmodule('applications')) {
			$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
			$options['conditions'][] = array('status = ?', Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_NEW);
			$applications = Rakuun_DB_Containers::getAlliancesApplicationsContainer()->count($options);
			$navigation->addModuleNode($parent->getSubmodule('applications'), 'Bewerbungen ('.$applications.')');
		}
		if ($parent->hasSubmodule('kick')) {
			$navigation->addModuleNode($parent->getSubmodule('kick'), 'Member Kicken');
		}
		if ($parent->hasSubmodule('diplomacy'))
			$navigation->addModuleNode($parent->getSubmodule('diplomacy'), 'Diplomatie');
		if ($parent->hasSubmodule('board'))
			$navigation->addModuleNode($parent->getSubmodule('board'), 'Forum ('.Rakuun_Intern_GUI_Panel_Alliance_Board::getNewPostingsCount().')');
		if ($parent->hasSubmodule('statistics'))
			$navigation->addModuleNode($parent->getSubmodule('statistics'), 'Statistiken');
		if ($parent->hasSubmodule('polls'))
			$navigation->addModuleNode($parent->getSubmodule('polls'), 'Umfragen');
		if ($parent->hasSubmodule('mail'))
			$navigation->addModuleNode($parent->getSubmodule('mail'), 'Rundmail schreiben');
		if ($parent->hasSubmodule('account'))
			$navigation->addModuleNode($parent->getSubmodule('account'), 'Allianzkonto');
		if ($parent->hasSubmodule('invite'))
			$navigation->addModuleNode($parent->getSubmodule('invite'), 'Einladung verschicken');
		if ($parent->hasSubmodule('build'))
			$navigation->addModuleNode($parent->getSubmodule('build'), 'Allianz-Gebäude');
		$this->contentPanel->params->navigation = $navigation;
	}
}

?>