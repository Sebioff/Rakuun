<?php

class Rakuun_Cronjob_Script_Tick extends Rakuun_Cronjob_Script {
	public function execute() {
		// finish productions for not logged-in players ------------------------
		$options = array();
		$options['conditions'][] = array('is_online < ?', time() - Rakuun_Intern_Module::TIMEOUT_ISONLINE);
		foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $user) {
			DB_Connection::get()->beginTransaction();
			// produce ressources (needs to be done first due to mines and stores)
			$user->produceRessources();
			// produce buildings
			new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getBuildingsContainer(), Rakuun_DB_Containers::getBuildingsWIPContainer(), $user);
			// produce technologies
			new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getTechnologiesContainer(), Rakuun_DB_Containers::getTechnologiesWIPContainer(), $user);
			// produce units
			new Rakuun_Intern_Production_Producer_Units(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers::getUnitsWIPContainer(), $user);
			// TODO quickfix: noob protection calculation isn't done everytime that is needed yet (e.g. when finishing units or the noob protection limits are raised)
			$user->recalculatePoints();
			DB_Connection::get()->commit();
		}
		
		// finish alliance buildings -------------------------------------------
		foreach (Rakuun_DB_Containers::getAlliancesContainer()->select() as $alliance) {
			DB_Connection::get()->beginTransaction();
			// produce buildings
			new Rakuun_Intern_Production_Producer_Alliances($alliance);
			DB_Connection::get()->commit();
		}
		
		// finish meta buildings -----------------------------------------------
		foreach (Rakuun_DB_Containers::getMetasContainer()->select() as $meta) {
			DB_Connection::get()->beginTransaction();
			// produce buildings
			new Rakuun_Intern_Production_Producer_Metas($meta);
			DB_Connection::get()->commit();
		}
		
		// remove alliance diplomacies after notice-time -----------------------
		DB_Connection::get()->beginTransaction();
		$options = array();
		$options['conditions'][] = array('status = ?', Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::STATUS_DELETED);
		foreach (Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->select($options) as $diplomacy) {
			if (($diplomacy->notice * 60 * 60) + $diplomacy->date <= time()) {
				$diplomacy->delete();
			}
		}
		DB_Connection::get()->commit();
	}
}

?>