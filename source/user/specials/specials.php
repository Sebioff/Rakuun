<?php

abstract class Rakuun_User_Specials {
	const SPECIAL_WARPGATE = 1;
	const SPECIAL_DATABASE_GREEN = 2;
	const SPECIAL_DATABASE_RED = 3;
	const SPECIAL_DATABASE_YELLOW = 4;
	const SPECIAL_DATABASE_BLUE = 5;
	const SPECIAL_DATABASE_BROWN = 6;
	const SPECIAL_PRESENT = 7;
	const SPECIAL_WALKOUT = 8;
	
	const PARAM_DATABASE_MOVED = 1;
	
	const EFFECTVALUE_DATABASE_DEFENSE = 0.04;
	
	protected $active = true;
	protected $identifier = null;
	protected $user = null;
	
	/**
	 * @param $user the user who gets the special
	 * @param $identifier what special is this? (see self::SPECIAL_*)
	 * @param $active special is active from begin on
	 */
	public function __construct(Rakuun_DB_User $user, $identifier, $active = true) {
		$this->active = $active;
		$this->user = $user;
		$this->identifier = $identifier;
	}
	
	/**
	 * checks if given user owns this special
	 * @return bool
	 */
	public function hasSpecial() {
		$special = $this->loadFromDB();
		if ($special) {
			return ($special->active == true);
		}
		return false;
	}
	
	/**
	 * give a special to an user; extend this function if special needs params
	 */
	public function giveSpecial() {
		$special = new DB_Record();
		$special->user = $this->user;
		$special->identifier = $this->identifier;
		$special->active = $this->active;
		if ($this->canReceive()) {
			Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->save($special);
			return $special;
		}
		return null;
	}
	
	/**
	 * activate the special, e.g. when user payed warpgate costs
	 */
	protected function activate() {
		DB_Connection::get()->beginTransaction();
		$special = $this->loadFromDB();
		$special->active = true;
		Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->save($special);
		Rakuun_DB_Containers::getSpecialsParamsContainer()->deleteBySpecialsUsers($special);
		DB_Connection::get()->commit();
	}
	
	public function setParam($key, $value) {
		if ($param = $this->getParam($key)) {
			$param->value = $value;
			$param->save();
		}
		else {
			$record = new DB_Record();
			$record->specialsUsers = $this->loadFromDB();
			$record->key = $key;
			$record->value = $value;
			Rakuun_DB_Containers::getSpecialsParamsContainer()->save($record);
		}
	}
	
	/**
	 * @return DB_Record
	 */
	public function getParam($key) {
		$options = array();
		$options['conditions'][] = array('specials_users = ?', $this->loadFromDB());
		$options['conditions'][] = array('`key` = ?', $key);
		return Rakuun_DB_Containers::getSpecialsParamsContainer()->selectFirst($options);
	}
	
	/**
	 * get the params for this special, e.g. costs for warpgate
	 */
	public function getParams() {
		$params = Rakuun_DB_Containers::getSpecialsParamsContainer()->selectBySpecialsUsers($this->loadFromDB());
		$_params = array();
		foreach ($params as $param) {
			$_params[$param->key] = $param->value;
		}
		return empty($_params) ? null : $_params;
	}
	
	protected function loadFromDB() {
		$options['conditions'][] = array('user = ?', $this->user);
		$options['conditions'][] = array('identifier = ?', $this->identifier);
		return Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectFirst($options);
	}
	
	/**
	 * remove this special from given user
	 */
	public function remove() {
		$options['conditions'][] = array('user = ?', $this->user);
		$options['conditions'][] = array('identifier = ?', $this->identifier);
		Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->delete($options);
	}
	
	/**
	 * checks if given user can receive this special
	 * @return bool
	 */
	public function canReceive() {
		return !(bool)$this->loadFromDB();
	}
	
	/**
	 * @return names for the Specials
	 */
	static public function getNames() {
		$names = array(
			Rakuun_User_Specials::SPECIAL_WARPGATE => 'Warpgate',
			Rakuun_User_Specials::SPECIAL_DATABASE_BLUE => 'Blaues DB',
			Rakuun_User_Specials::SPECIAL_DATABASE_RED => 'Rotes DB',
			Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW => 'Gelbes DB',
			Rakuun_User_Specials::SPECIAL_DATABASE_BROWN => 'Braunes DB',
			Rakuun_User_Specials::SPECIAL_DATABASE_GREEN => 'Grünes DB'
		);
		return $names;
	}
	
	/**
	 * @return effects of the Specials
	 */
	static public function getEffects() {
		$effectValues = Rakuun_User_Specials::getEffectValues();
		$effects = array(
			Rakuun_User_Specials::SPECIAL_WARPGATE => 'reduziert eigene Armeebewegungszeit um '.$effectValues[Rakuun_User_Specials::SPECIAL_WARPGATE] * 100 .'%',
			Rakuun_User_Specials::SPECIAL_DATABASE_BLUE => '+'.(self::EFFECTVALUE_DATABASE_DEFENSE * 100).'% Verteidigungskraft für den Halter; Reduziert Armeebewegungszeit aller Metamitglieder um +'.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_BLUE] * 100 .'% täglich pro Ausbaustufe des Datenbankdetektors',
			Rakuun_User_Specials::SPECIAL_DATABASE_RED => '+'.(self::EFFECTVALUE_DATABASE_DEFENSE * 100).'% Verteidigungskraft für den Halter; Erhöht Angriffskraft aller Metamitglieder um +'.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_RED] * 100 .'% täglich pro Ausbaustufe des Datenbankdetektors',
			Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW => '+'.(self::EFFECTVALUE_DATABASE_DEFENSE * 100).'% Verteidigungskraft für den Halter; Reduziert Einheitenproduktionszeit aller Metamitglieder um +'.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW] * 100 .'% täglich pro Ausbaustufe des Datenbankdetektors',
			Rakuun_User_Specials::SPECIAL_DATABASE_BROWN => '+'.(self::EFFECTVALUE_DATABASE_DEFENSE * 100).'% Verteidigungskraft für den Halter; Erhöht Ressourcenproduktion von Eisen und Beryllium aller Metamitglieder um +'.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_BROWN] * 100 .'% täglich pro Ausbaustufe des Datenbankdetektors',
			Rakuun_User_Specials::SPECIAL_DATABASE_GREEN => '+'.(self::EFFECTVALUE_DATABASE_DEFENSE * 100).'% Verteidigungskraft für den Halter; Erhöht Verteidigungskraft aller Metamitglieder um +'.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_GREEN] * 100 .'% täglich pro Ausbaustufe des Datenbankdetektors'
		);
		return $effects;
	}
	
	/**
	 * @return effectvalues of the Specials
	 */
	public static function getEffectValues() {
		$effectsValues = array(
			Rakuun_User_Specials::SPECIAL_WARPGATE => 0.5,
			Rakuun_User_Specials::SPECIAL_DATABASE_BLUE => 0.006,
			Rakuun_User_Specials::SPECIAL_DATABASE_RED => 0.0006,
			Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW => 0.004,
			Rakuun_User_Specials::SPECIAL_DATABASE_BROWN => 0.0006,
			Rakuun_User_Specials::SPECIAL_DATABASE_GREEN => 0.0005
		);
		return $effectsValues;
	}
}
?>