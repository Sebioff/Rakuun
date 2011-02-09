<?php

class Rakuun_Intern_GUI_Panel_Map_Descriptions_City extends GUI_Panel_HoverInfo {
	private $cityOwner = null;
	private $map = null;
	
	public function __construct(Rakuun_DB_User $cityOwner, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct('city'.$cityOwner->getPK(), '', 'Wird geladen...');
		
		$this->cityOwner = $cityOwner;
		$this->map = $map;
		
		$this->enableAjax(true, array($this, 'getCityDescription'));
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
		', $this->getID(), $this->map->target->target->targetX->getID(), $this->cityOwner->cityX, $this->map->target->target->targetY->getID(), $this->cityOwner->cityY, $this->map->target->target->target->getID(), str_replace('\'', '\\\'', $this->getCityOwner()->nameUncolored)));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_User
	 */
	public function getCityOwner() {
		return $this->cityOwner;
	}
	
	public function getCityDescription() {
		$hoverText = '';
		$userLink = new Rakuun_GUI_Control_UserLink('userlink', $this->cityOwner, $this->cityOwner->getPK());
		$igmLink = new Rakuun_GUI_Control_SendMessageLink('igmlink', $this->cityOwner);
		if ($this->cityOwner->alliance) {
			$allianceLink = new Rakuun_GUI_Control_AllianceLink('alliancelink', $this->cityOwner->alliance);
			$allianceLink->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			$hoverText .= str_replace('"', '\"', $allianceLink->render()).' ';
		}
		$hoverText .= str_replace('"', '\"', $userLink->render()).
			'<br />'.Text::escapeHTML($this->cityOwner->cityName).
			'<br />Punkte: '.GUI_Panel_Number::formatNumber($this->cityOwner->points);
			$hoverText .= '<br />Spieler ist ';
			if ($this->cityOwner->isOnline())
				$hoverText .= 'online';
			else
				$hoverText .= 'offline';
			$hoverText .= '<br />'.str_replace('"', '\"', $igmLink->render());
			if ($this->cityOwner->isInNoob())
				$hoverText .= '<br />Spieler befindet sich im Noobschutz';
			if ($this->cityOwner->isYimtay())
				$hoverText .= '<br />Der Spieler ist inaktiv';
		return $hoverText;
	}
}

?>