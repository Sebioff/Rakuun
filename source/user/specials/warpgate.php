<?php

class Rakuun_User_Specials_Warpgate extends Rakuun_User_Specials {
	const BASE_IRON_COSTS = 20000;
	const BASE_BERYLLIUM_COSTS = 20000;
	
	private static $instance = null;
	
	public static function get(Rakuun_DB_User $user) {
		return (self::$instance) ? self::$instance : self::$instance = new self($user, parent::SPECIAL_WARPGATE, false);
	}
	
	public function giveSpecial() {
		DB_Connection::get()->beginTransaction();
		$special = parent::giveSpecial();
		if ($special) {
			$ironRecord = new DB_Record();
			$ironRecord->specialsUsers = $special;
			$ironRecord->key = 'iron';
			$ironRecord->value = round(self::BASE_IRON_COSTS * $this->getMultiplicator());
			Rakuun_DB_Containers::getSpecialsParamsContainer()->save($ironRecord);
			$berylliumRecord = new DB_Record();
			$berylliumRecord->specialsUsers = $special;
			$berylliumRecord->key = 'beryllium';
			$berylliumRecord->value = round(self::BASE_BERYLLIUM_COSTS * $this->getMultiplicator());
			Rakuun_DB_Containers::getSpecialsParamsContainer()->save($berylliumRecord);
			DB_Connection::get()->commit();
		} else {
			DB_Connection::get()->rollback();
		}
	}
	
	/**
	 * Pay the ressources for this special.
	 * @param $iron
	 * @param $beryllium
	 * @return boolean
	 */
	public function pay($iron, $beryllium) {
		$params = $this->getParams();
		if ($params && $params['iron'] == $iron && $params['beryllium'] == $beryllium) {
			$this->activate();
			$this->user->ressources->lower($iron, $beryllium);
			return true;
		} else {
			return false;
		}
	}
	
	protected function getMultiplicator() {
		return mt_rand(7500, 17500) / 10000;
	}
}
?>