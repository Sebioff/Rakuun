<?php

class Rakuun_User_Specials_Walkout extends Rakuun_User_Specials {
	const BASE_DURATION = 21600;
	
	private static $instance = null;
	
	public static function get(Rakuun_DB_User $user) {
		return (self::$instance) ? self::$instance : self::$instance = new self($user, parent::SPECIAL_WALKOUT);
	}
	
	public function giveSpecial() {
		DB_Connection::get()->beginTransaction();
		$special = parent::giveSpecial();
		$paramsDuration = new DB_Record();
		$paramsDuration->specialsUsers = $special;
		$paramsDuration->key = 'duration';
		$paramsDuration->value = round(self::BASE_DURATION * $this->getMultiplicator());
		Rakuun_DB_Containers::getSpecialsParamsContainer()->save($paramsDuration);
		$paramsStart = new DB_Record();
		$paramsStart->specialsUsers = $special;
		$paramsStart->key = 'start';
		$paramsStart->value = time();
		Rakuun_DB_Containers::getSpecialsParamsContainer()->save($paramsStart);
		Rakuun_User_Callbacks::get($this->user)->add(array($this, 'remove'), Rakuun_User_Callbacks::STYLE_GET_USER);
		DB_Connection::get()->commit();
	}
	
	protected function getMultiplicator() {
		return mt_rand(50000, 150000) / 100000;
	}
	
	public function remove() {
		$params = $this->getParams();
		if ($params['duration'] + $params['start'] <= time()) {
			parent::remove();
			return true;
		} else
			return false;
	}
}
?>