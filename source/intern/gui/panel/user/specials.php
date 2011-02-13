<?php

class Rakuun_Intern_GUI_Panel_User_Specials extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/specials.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		
		$this->addPanel($specials = new GUI_Panel_Table('specials', 'Specials'));
		$specials->addHeader(array('Name', 'Effekt'));
		
		$names = Rakuun_User_Specials::getNames();
		$effects = Rakuun_User_Specials::getEffects();
		
		//databases
		$options = array();
		$options['conditions'][] = array('identifier IN ('.implode(', ', Rakuun_User_Specials_Database::getDatabaseIdentifiers()).')');
		$options['conditions'][] = array('user = ?', $user);
		$options['conditions'][] = array('active = ?', true);
		$databases = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->select($options);
		
		foreach ($databases as $database) {
			$line = array();
			$line[] = $names[$database->identifier];
			$line[] = $effects[$database->identifier];;
			$specials->addLine($line);
		}
		
		//user specific Specials
		//TODO
	}
}

?>