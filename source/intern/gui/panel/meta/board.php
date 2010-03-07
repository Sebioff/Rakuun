<?php

class Rakuun_Intern_GUI_Panel_Meta_Board extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		parent::__construct($name, Rakuun_DB_Containers::getBoardsMetaContainer()->getFilteredContainer(self::getMetaFilter()), $title);
	}
	
	protected function getFilteredRecord() {
		$record = new DB_Record();
		$record->meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
		return $record;
	}
	
	private static function getMetaFilter() {
		$options = array();
		$options['conditions'][] = array('meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
		return $options; 
	}
	
	protected function getPostingsContainer() {
		return Rakuun_DB_Containers::getBoardsMetaPostingsContainer();
	}
	
	protected function getVisitedContainer() {
		return Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer();
	}
	
	public static function getNewPostingsCount(DB_Container $null = null, DB_Container $anothernull = null) {
		return parent::getNewPostingsCount(
			Rakuun_DB_Containers::getBoardsMetaContainer()->getFilteredContainer(self::getMetaFilter()),
			Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer()
		);
	}
}
?>