<?php

class Rakuun_Intern_GUI_Panel_Meta_Found extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/found.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name'));
		$name->setTitle('Name');
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'gründen'));
	}
	
	public function onSubmit() {
		DB_Connection::get()->beginTransaction();
		$metaExists = Rakuun_DB_Containers::getMetasContainer()->selectFirst(array('conditions' => array(array('name LIKE ?', $this->name))));
		if ($metaExists) {
			$this->addError('Eine Meta mit diesem Namen existiert bereits');
		}
		
		if ($this->hasErrors())
			return;
		
		$meta = new Rakuun_DB_Meta();
		$meta->name = $this->name;
		Rakuun_DB_Containers::getMetasContainer()->save($meta);
		$metaBuildings = new DB_Record();
		$metaBuildings->meta = $meta;
		Rakuun_DB_Containers::getMetasBuildingsContainer()->save($metaBuildings);
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->alliance->meta = $meta;
		Rakuun_User_Manager::update($user);
		Rakuun_DB_Containers::getAlliancesContainer()->save($user->alliance);
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>