<?php

class Rakuun_User_Specials_Present extends Rakuun_User_Specials {
	const BASE_IRON = 2000;
	const BASE_BERYLLIUM = 2000;
	const BASE_ENERGY = 1000;
	
	private static $instance = null;
	
	public static function get(Rakuun_DB_User $user) {
		return (self::$instance) ? self::$instance : self::$instance = new self($user, parent::SPECIAL_PRESENT);
	}
	
	public function giveSpecial() {
		DB_Connection::get()->beginTransaction();
		$paramsIron = new DB_Record();
		$paramsIron->specialsUsers = parent::giveSpecial();
		$paramsIron->key = 'iron';
		$paramsIron->value = round(self::BASE_IRON * $this->getMultiplicator());
		Rakuun_DB_Containers::getSpecialsParamsContainer()->save($paramsIron);
		$paramsBeryllium = new DB_Record();
		$paramsBeryllium->specialsUsers = $paramsIron->specialsUsers;
		$paramsBeryllium->key = 'beryllium';
		$paramsBeryllium->value = round(self::BASE_BERYLLIUM * $this->getMultiplicator());
		Rakuun_DB_Containers::getSpecialsParamsContainer()->save($paramsBeryllium);
		$paramsEnergy = new DB_Record();
		$paramsEnergy->specialsUsers = $paramsIron->specialsUsers;
		$paramsEnergy->key = 'energy';
		$paramsEnergy->value = round(self::BASE_ENERGY * $this->getMultiplicator());
		Rakuun_DB_Containers::getSpecialsParamsContainer()->save($paramsEnergy);
		DB_Connection::get()->commit();
	}
	
	protected function getMultiplicator() {
		return mt_rand(750, 1250) / 1000;
	}
	
	public function payout() {
		$params = $this->getParams();
		$this->user->ressources->raise($params['iron'], $params['beryllium'], $params['energy']);
		$this->remove();
	}
}
?>