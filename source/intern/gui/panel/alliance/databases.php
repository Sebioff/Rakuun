<?php

/**
 * Panel that displays all databases of the alliances' meta.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Databases extends GUI_Panel {
	private $alliance = null;
	
	public function __construct($name, Rakuun_DB_Alliance $alliance) {
		parent::__construct($name);

		$this->alliance = $alliance;
		$this->setTemplate(dirname(__FILE__).'/databases.tpl');
	}
	
	public function getMetaDatabases() {
		$options = array();
		$userTable = Rakuun_DB_Containers::getUserContainer()->getTable();
		$allianceTable = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$specialsUsersAssocTable = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->getTable();
		$options['join'] = array($userTable, $allianceTable);
		$options['group'] = $specialsUsersAssocTable.'.identifier';
		if (!$this->alliance->meta) {
			$options['conditions'][] = array($userTable.'.alliance = ?', $this->alliance);
		}
		else {
			$options['conditions'][] = array('('.$userTable.'.alliance = ?) OR ('.$userTable.'.alliance = '.$allianceTable.'.id && '.$allianceTable.'.meta = ?)', $this->alliance, $this->alliance->meta);
		}
		$options['conditions'][] = array($specialsUsersAssocTable.'.user = '.$userTable.'.id');
		$options['conditions'][] = array($specialsUsersAssocTable.'.identifier IN ('.implode(', ', Rakuun_User_Specials_Database::getDatabaseIdentifiers()).')');
		$options['conditions'][] = array($specialsUsersAssocTable.'.active = ?', true);
		return Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->select($options);
	}
}

?>