<?php

class Rakuun_Intern_GUI_Panel_Map_Databases extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/databases.tpl');
		
		$this->params->visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance(Rakuun_User_Manager::getCurrentUser()->alliance);
		$images = Rakuun_User_Specials_Database::getDatabaseImages();
		
		$names = Rakuun_User_Specials::getNames();
		
		foreach ($this->params->visibleDatabases as $db) {
			$this->addPanel(new GUI_Panel_Image('image_'.$db, Router::get()->getStaticRoute('images', $images[$db].'.gif')));
			$options = array();
			$options['conditions'][] = array('identifier = ?', $db);
			$assoc = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectFirst($options);
			if ($assoc) {
				$this->addPanel(new Rakuun_GUI_Control_UserLink('link_'.$db, $assoc->user));
			} else {
				$koords = Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->selectFirst($options);
				//TODO: change this to JS-Link with map-scrolling etc
				$this->addPanel(new GUI_Control_Link('link_'.$db, $names[$db], App::get()->getInternModule()->getSubmodule('map')->getURL(array('cityX' => $koords->positionX, 'cityY' => $koords->positionY))));
			}
		}
	}
}
?>