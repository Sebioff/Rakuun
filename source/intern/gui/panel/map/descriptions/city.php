<?php

class Rakuun_Intern_GUI_Panel_Map_Descriptions_City extends GUI_Panel_HoverInfo {
	private $cityOwner = null;
	private $map = null;
	
	public function __construct(Rakuun_DB_User $cityOwner, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct('city'.$cityOwner->getPK(), '', '');
		
		$this->cityOwner = $cityOwner;
		$this->map = $map;
		
		$hoverText = '';
		$userLink = new Rakuun_GUI_Control_UserLink('userlink', $cityOwner, $cityOwner->getPK());
		$igmLink = new Rakuun_GUI_Control_SendMessageLink('igmlink', $cityOwner);
		if ($cityOwner->alliance) {
			$allianceLink = new Rakuun_GUI_Control_AllianceLink('alliancelink', $cityOwner->alliance);
			$allianceLink->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			$hoverText .= str_replace('"', '\"', $allianceLink->render()).' ';
		}
		$hoverText .= str_replace('"', '\"', $userLink->render()).
			'<br />'.Text::escapeHTML($cityOwner->cityName).
			'<br />Punkte: '.GUI_Panel_Number::formatNumber($cityOwner->points);
			$hoverText .= '<br />Spieler ist ';
			if ($cityOwner->isOnline())
				$hoverText .= 'online';
			else
				$hoverText .= 'offline';
			$hoverText .= '<br />'.str_replace('"', '\"', $igmLink->render());
			if ($cityOwner->isInNoob())
				$hoverText .= '<br />Spieler befindet sich im Noobschutz';
			if ($cityOwner->isYimtay())
				$hoverText .= '<br />Der Spieler ist inaktiv';
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
		$this->addJS(sprintf('
			$("#%s").click(function(event) {
				$(\'#%s\').val(\'%s\');
				$(\'#%s\').val(\'%s\');
				$(\'#%s\').val(\'%s\');
				return false;
			});
		', $this->getID(), $this->map->target->target->targetX->getID(), $this->cityOwner->cityX, $this->map->target->target->targetY->getID(), $this->cityOwner->cityY, $this->map->target->target->target->getID(), $this->getCityOwner()->nameUncolored));
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