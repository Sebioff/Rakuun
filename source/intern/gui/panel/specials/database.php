<?php

class Rakuun_Intern_GUI_Panel_Specials_Database extends GUI_Panel_HoverInfo {
	private $databaseIdentifier;
	private $user = null;
	
	/**
	 * @param Rakuun_DB_User $user the user for whom the current effect should be shown
	 */
	public function __construct($name, $databaseIdentifier, Rakuun_DB_User $user = null) {
		$this->databaseIdentifier = $databaseIdentifier;
		$this->user = $user;
		$images = Rakuun_User_Specials_Database::getDatabaseImages();
		$image = new GUI_Panel_Image('image_'.$databaseIdentifier, Router::get()->getStaticRoute('images', $images[$databaseIdentifier].'.gif'));
		parent::__construct($name, $image->render(), 'Wird geladen...');
		$this->enableAjax(true, array($this, 'getDatabaseDescription'));
	}
	
	public function getDatabaseDescription() {
		$effects = Rakuun_User_Specials::getEffects();
		$effectDescription = $effects[$this->databaseIdentifier];
		if ($this->user) {
			$database = new Rakuun_User_Specials_Database($this->user, $this->databaseIdentifier);
			$moveTime = $database->getParam(Rakuun_User_Specials::PARAM_DATABASE_MOVED)->value;
			$effectDescription .= ' (aktuell: '.Rakuun_Date::formatCountDown(time() - $moveTime).' gehalten)';
		}
		return $effectDescription;
	}
}