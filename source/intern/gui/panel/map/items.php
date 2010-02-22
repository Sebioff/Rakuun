<?php

class Rakuun_Intern_GUI_Panel_Map_Items extends GUI_Panel {
	private $map = null;
	private $scrollItems = array();
	
	public function __construct($name, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct($name);
		
		$this->map = $map;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/items.tpl');
		if (Rakuun_User_Manager::getCurrentUser()->alliance && Rakuun_User_Manager::getCurrentUser()->alliance->buildings->databaseDetector > 0) {
			$visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance(Rakuun_User_Manager::getCurrentUser()->alliance);
			if (!empty($visibleDatabases)) {
				$options = array();
				$options['conditions'][] = array('identifier IN ('.implode(', ', $visibleDatabases).')');
				foreach (Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->select($options) as $databasePosition) {
					$this->addPanel($databasePanel = new Rakuun_Intern_GUI_Panel_Map_Descriptions_Database($this->map, $databasePosition->identifier, $databasePosition->positionX, $databasePosition->positionY));
					$this->scrollItems[] = $databasePanel;
				}
			}
		}
		
		foreach (Rakuun_DB_Containers::getUserContainer()->select() as $city) {
			$this->addPanel($cityPanel = new Rakuun_Intern_GUI_Panel_Map_Descriptions_City($city, $this->map));
			$this->scrollItems[] = $cityPanel;
		}
		
		foreach (Rakuun_User_Manager::getCurrentUser()->armies as $army) {
			$this->addPanel($armyPanel = new Rakuun_Intern_GUI_Panel_Map_Descriptions_Army($army, $this->map));
			$this->scrollItems[] = $armyPanel;
		}
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'position:absolute',
			'height:'.Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'width:'.Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'left:'.(-$this->getMap()->getViewRectX() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px',
			'top:'.(-$this->getMap()->getViewRectY() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px'
		);
		$this->setAttribute('src', App::get()->getMapItemsModule()->getURL().'?cb='.time());
		$this->setAttribute('style', implode(';', $style));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getScrollItems() {
		return $this->scrollItems;
	}
	
	public function getMap() {
		return $this->map;
	}
}

?>