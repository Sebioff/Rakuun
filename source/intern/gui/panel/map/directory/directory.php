<?php

abstract class Rakuun_Intern_GUI_Panel_Map_Directory extends GUI_Panel {
	protected $options = array();
	
	public function init() {
		parent::init();
		
		$this->addPanel($list = new GUI_Panel_List('list'));
		$i = 0;
		foreach (Rakuun_DB_Containers::getLogOutgoingArmiesContainer()->select($this->options) as $fight) {
			$panel = new GUI_Panel('links_'.$i);
			$panel->addPanel(new Rakuun_GUI_Control_MapLink('maplink', $fight->opponent));
			$panel->addPanel(new Rakuun_GUI_Control_UserLink('userlink', $fight->opponent));
			$list->addItem($panel);
			$i++;
		}
	}
}
?>