<?php

class Rakuun_Intern_GUI_Panel_Map_City extends GUI_Panel_HoverInfo {
	private $cityOwner = null;
	private $map = null;
	
	public function __construct(Rakuun_DB_User $cityOwner, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct('city'.$cityOwner->getPK(), '', '');
		
		$this->cityOwner = $cityOwner;
		$this->map = $map;
		
		if ($this->cityOwner->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK())
			$this->addClasses('rakuun_city_own');
		elseif ($this->cityOwner->alliance && Rakuun_User_Manager::getCurrentUser()->alliance) {
			if ($this->cityOwner->alliance->getPK() == Rakuun_User_Manager::getCurrentUser()->alliance)
				$this->addClasses('rakuun_city_allied');
			$diplomacy = $this->cityOwner->alliance->getDiplomacy(Rakuun_User_Manager::getCurrentUser()->alliance);
			if ($diplomacy) {
				if ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_AUVB)
					$this->addClasses('rakuun_city_allied');
				if ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_WAR)
					$this->addClasses('rakuun_city_hostile');
				if ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_NAP)
					$this->addClasses('rakuun_city_friendly');
			}
		}
		
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
		$this->addClasses('scroll_item', 'rakuun_city');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'left:'.$this->map->realToViewPositionX($this->cityOwner->cityX).'px',
			'top:'.$this->map->realToViewPositionY($this->cityOwner->cityY).'px'
		);
		$this->setAttribute('style', implode(';', $style));
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