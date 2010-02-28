<?php

class Rakuun_GUI_Control_AllianceLink extends GUI_Control_Link {
	const DISPLAY_TAG_ONLY = 1;
	const DISPLAY_NAME_ONLY = 2;
	const DISPLAY_TAG_AND_NAME = 3;
	
	private $alliance = null;
	
	public function __construct($name, Rakuun_DB_Alliance $alliance, $title = '') {
		parent::__construct($name, '['.$alliance->tag.'] '.$alliance->name, App::get()->getInternModule()->getSubmodule('allianceview')->getURL(array('alliance' => $alliance->getPK())), $title);
		$this->alliance = $alliance;
	}
	
	public function setDisplay($display) {
		if ($display == self::DISPLAY_TAG_ONLY)
			$this->setCaption('['.$this->alliance->tag.']');
		elseif ($display == self::DISPLAY_NAME_ONLY)
			$this->setCaption($this->alliance->name);
		elseif ($display == self::DISPLAY_TAG_AND_NAME)
			$this->setCaption('['.$this->alliance->tag.'] '.$this->alliance->name);
	}
}

?>