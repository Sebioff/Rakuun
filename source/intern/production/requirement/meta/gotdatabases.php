<?php

/**
 * Checks if the meta owns 3 databases
 */
class Rakuun_Intern_Production_Requirement_Meta_GotDatabases extends Rakuun_Intern_Production_Requirement_Base {
	public function getDescription() {
		return 'Meta muss drei Datenbankteile besitzen';
	}
	
	public function fulfilled() {
		$options = array();
		$userSpecialsTable = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->getTable();
		$userTable = Rakuun_DB_Containers::getUserContainer()->getTable();
		$alliancesTable = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$metasTable = Rakuun_DB_Containers::getMetasContainer()->getTable();
		$options['join'] = array($userTable, $alliancesTable, $metasTable);
		$options['conditions'][] = array($userSpecialsTable.'.active = ?', true);
		$options['conditions'][] = array($userSpecialsTable.'.identifier IN ('.implode(', ', Rakuun_User_Specials_Database::getDatabaseIdentifiers()).')');
		$options['conditions'][] = array($userSpecialsTable.'.user = '.$userTable.'.id');
		$options['conditions'][] = array($userTable.'.alliance = '.$alliancesTable.'.id');
		$options['conditions'][] = array($alliancesTable.'.meta = '.$metasTable.'.id');
		$options['conditions'][] = array($metasTable.'.id = ?', $this->getProductionItem()->getOwner());
		return (Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->count($options) >= 3);
	}
}

?>