<?php

class Rakuun_Cronjob_Script_DailyCleanup extends Rakuun_Cronjob_Script_FixedTime {
	public function execute() {
		// RESET ALLIANCE INVITATION COUNTER -----------------------------------
		$query = 'UPDATE alliances SET invitations = 0';
		DB_Connection::get()->query($query);
		
		// RESET USER'S STOCKMARKET TRADEVOLUME --------------------------------
		// TODO could easily be done without cronjob...
		$query = 'UPDATE users SET stockmarkettrade = 0, tradelimit = 0';
		DB_Connection::get()->query($query);
		
		// LITTLE CHEAT FOR STOCKMARKET PRICE DISPLAY --------------------------
		$options = array();
		$options['order'] = 'date DESC';
		$price = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		if ($price->date < strtotime('-1 day', mktime(12, 0, 0))) {
			$newPrice = new DB_Record();
			$newPrice->date = mktime(12, 0, 0);
			$newPrice->iron = $price->iron;
			$newPrice->beryllium = $price->beryllium;
			$newPrice->energy = $price->energy;
			Rakuun_DB_Containers::getStockmarketContainer()->save($newPrice);
		}
	}
}

?>