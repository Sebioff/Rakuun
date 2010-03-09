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
			Rakuun_User_Specials::SPECIAL_DATABASE_BLUE => 'wirkt wie ein Warpgate',
			Rakuun_User_Specials::SPECIAL_DATABASE_RED => 'erhöht Angriffskraft um '.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_RED] * 100 .'%',
			Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW => 'reduziert Einheitenproduktionszeit um '.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW] * 100 .'%',
			Rakuun_User_Specials::SPECIAL_DATABASE_BROWN => 'erhöht Ressourcenproduktion um '.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_BROWN] * 100 .'%',
			Rakuun_User_Specials::SPECIAL_DATABASE_GREEN => 'erhöht Verteidigungskraft um '.$effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_GREEN] * 100 .'%'
		);
		return $effects;
	}
	
	/**
	 * @return effectvalues of the Specials
	 */
	static public function getEffectValues() {
		$effectsValues = array(
			Rakuun_User_Specials::SPECIAL_WARPGATE => 0.5,
			Rakuun_User_Specials::SPECIAL_DATABASE_BLUE => Rakuun_User_Specials::SPECIAL_WARPGATE,
			Rakuun_User_Specials::SPECIAL_DATABASE_RED => 0.04,
			Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW =>0.1,
			Rakuun_User_Specials::SPECIAL_DATABASE_BROWN => 0.1,
			Rakuun_User_Specials::SPECIAL_DATABASE_GREEN => 0.04
		);
		return $effectsValues;
	}
}
?>