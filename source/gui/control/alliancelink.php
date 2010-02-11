<?php

class Rakuun_GUI_Control_AllianceLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_Alliance $alliance, $title = '') {
		parent::__construct($name, '['.$alliance->tag.'] '.$alliance->name, App::get()->getInternModule()->getSubmodule('allianceview')->getURL(array('alliance' => $alliance->getPK())), $title);
	}
}

?>