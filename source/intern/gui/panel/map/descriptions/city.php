<?php

class Rakuun_Intern_GUI_Panel_Map_Descriptions_City extends GUI_Panel_HoverInfo {
	private $cityOwner = null;
	private $map = null;
	
	public function __construct(Rakuun_DB_User $cityOwner, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct('city'.$cityOwner->getPK(), '', '');
		
		$this->cityOwner = $cityOwner;
		$this->map = $map;
		
		$hoverText = $cityOwner->nameUncolored.
			'<br/>'.Text::escapeHTML($cityOwner->cityName).
			'<br/>Punkte: '.GUI_Panel_Number::formatNumber($cityOwner->points);
			if ($cityOwner->alliance)
				$hoverText .= '<br/>Allianz: '.$cityOwner->alliance->name;
			$hoverText .= '<br/>Spieler ist ';
			if ($cityOwner->isOnline())
				$hoverText .= 'online';
			else
				$hoverText .= 'offline';
			if ($cityOwner->isInNoob())
				$hoverText .= '<br/>Spieler befindet sich im Noobschutz';
		$this->setHoverText($hoverText);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/city.tpl');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$x = $this->cityOwner->cityX * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE;
		$y = $this->cityOwner->cityY * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE;
		$this->setAttribute('coords', $x.','.$y.','.($x + 10).','.($y + 10));
		$this->setAttribute('onClick', sprintf('$(\'#%s\').val(\'%s\'); return false;', $this->map->target->target->target->getID(), $this->getCityOwner()->nameUncolored));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_User
	 */
	public function getCityOwner() {
		return $this->cityOwner;
	}
}

?>