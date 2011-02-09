<?php

class Rakuun_Intern_GUI_Panel_Specials_Database extends GUI_Panel_HoverInfo {
	private $databaseIdentifier;
	
	public function __construct($name, $databaseIdentifier) {
		$this->databaseIdentifier = $databaseIdentifier;
		$images = Rakuun_User_Specials_Database::getDatabaseImages();
		$image = new GUI_Panel_Image('image_'.$databaseIdentifier, Router::get()->getStaticRoute('images', $images[$databaseIdentifier].'.gif'));
		parent::__construct($name, $image->render(), 'Wird geladen...');
		$this->enableAjax(true, array($this, 'getDatabaseDescription'));
	}
	
	public function getDatabaseDescription() {
		$effects = Rakuun_User_Specials::getEffects();
		$database = new Rakuun_User_Specials_Database(Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectByIdentifierFirst($this->databaseIdentifier)->user, $this->databaseIdentifier);
		return $effects[$this->databaseIdentifier].' (aktuell: +'.($database->getEffectValue() * 100).'%)';
	}
}