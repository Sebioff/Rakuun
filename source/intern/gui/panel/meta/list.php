<?php

class Rakuun_Intern_GUI_Panel_Meta_List extends GUI_Panel {
	private $meta = null;
	
	public function __construct($name, DB_Record $meta, $title = '') {
		parent::__construct($name, $title);
		
		$this->meta = $meta;
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel($list = new GUI_Panel_List('list'));
		$options = array();
		$options['order'] = 'name ASC';
		foreach ($this->meta->alliances->select($options) as $alliance) {
			$link = new Rakuun_GUI_Control_AllianceLink('link'.$alliance->getPK(), $alliance);
			$list->addItem($link);
		}
	}
}
?>