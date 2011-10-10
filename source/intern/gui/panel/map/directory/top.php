<?php

class Rakuun_Intern_GUI_Panel_Map_Directory_Top extends Rakuun_Intern_GUI_Panel_Map_Directory {
	public function init() {
		$this->options['properties'] = '*, COUNT(*) as rank';
		$this->options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$this->options['group'] = 'opponent';
		$this->options['order'] = 'rank DESC, time DESC';
		$this->options['limit'] = 10;
		
		parent::init();
	}
}
?>