<?php

class Rakuun_Intern_GUI_Panel_Map_Databases extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/databases.tpl');
		
		$this->params->visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance(Rakuun_User_Manager::getCurrentUser()->alliance);
		
		$names = Rakuun_User_Specials::getNames();
		$isDemoUser = Rakuun_User_Manager::getCurrentUser()->isDemo();
		
		foreach ($this->params->visibleDatabases as $db) {
			$options = array();
			$options['conditions'][] = array('identifier = ?', $db);
			$user = null;
			if ($userAssoc = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectFirst($options))
				$user = $userAssoc->user;
				
			$this->addPanel(new Rakuun_Intern_GUI_Panel_Specials_Database('image_'.$db, $db, $user));
				
			if ($user) {
				if ($isDemoUser) {
					$this->addPanel(new GUI_Panel_Text('link_'.$db, 'Geheimnisträger '.mt_rand(100, 999)));
				} else {
					$this->addPanel(new Rakuun_GUI_Control_UserLink('link_'.$db, $user));
					if ($user->alliance) {
						$this->addPanel($alliancelink = new Rakuun_GUI_Control_AllianceLink('alliancelink_'.$db, $user->alliance));
						$alliancelink->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
					}
				}
			} else {
				$koords = Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->selectFirst($options);
				//TODO: change this to JS-Link with map-scrolling etc
				if ($koords)
					$this->addPanel(new GUI_Control_Link('link_'.$db, $names[$db], App::get()->getInternModule()->getSubmodule('map')->getURL(array('cityX' => $koords->positionX, 'cityY' => $koords->positionY))));
				else {
					//something wrong here
				}
			}
		}
	}
}
?>