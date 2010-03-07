<?php

class Rakuun_Intern_GUI_Panel_Alliance_Board extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		parent::__construct($name, Rakuun_DB_Containers::getBoardsAllianceContainer()->getFilteredContainer(self::getAllianceFilter()), $title);
	}
	
	protected function getFilteredRecord() {
		$record = new DB_Record();
		$record->alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		return $record;
	}
	
	private static function getAllianceFilter() {
		$options = array();
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		return $options; 
	}
	
	protected function getPostingsContainer() {
		return Rakuun_DB_Containers::getBoardsAlliancePostingsContainer();
	}
	
	protected function getVisitedContainer() {
		return Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer();
	}
	
	public static function getNewPostingsCount(DB_Container $null = null, DB_Container $anothernull = null) {
		return parent::getNewPostingsCount(
			Rakuun_DB_Containers::getBoardsAllianceContainer()->getFilteredContainer(self::getAllianceFilter()),
			Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer()
		);
	}
}
?>