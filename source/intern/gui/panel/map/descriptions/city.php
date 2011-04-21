<?php

class Rakuun_Intern_GUI_Panel_Map_Descriptions_City extends GUI_Panel_HoverInfo {
	private $cityOwner = null;
	private $map = null;
	
	public function __construct(Rakuun_DB_User $cityOwner, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct('city'.$cityOwner->getPK(), '', 'Wird geladen...');
		
		$this->cityOwner = $cityOwner;
		$this->map = $map;
		
		if ($this->visibleOnLoad())
			$this->setHoverText(str_replace('"', '\\"', $this->getCityDescription()));
		else
			$this->enableAjax(true, array($this, 'getCityDescription'));
		
		$this->enableLocking();
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
			$hoverText .= $allianceLink->render().' ';
		}
		$hoverText .= $userLink->render().
			'<br />'.Text::escapeHTML($this->cityOwner->cityName).
			'<br />Punkte: '.GUI_Panel_Number::formatNumber($this->cityOwner->points);
			$hoverText .= '<br />Spieler ist ';
			if ($this->cityOwner->isOnline())
				$hoverText .= 'online';
			else
				$hoverText .= 'offline';
			$hoverText .= '<br />'.$igmLink->render();
			if ($this->cityOwner->isInNoob())
				$hoverText .= '<br />Spieler befindet sich im Noobschutz';
			if ($this->cityOwner->isYimtay())
				$hoverText .= '<br />Der Spieler ist inaktiv';
				
		$newestReport = Rakuun_Intern_GUI_Panel_Reports_Base::getNewestReportForUser($this->cityOwner);
		if ($newestReport) {
			$att = 0;
			$deff = 0;
			foreach (Rakuun_Intern_Production_Factory::getAllUnits($newestReport) as $unit) {
				$att += $unit->getAttackValue();
				$deff += $unit->getDefenseValue();
			}
			
			$hoverText .= '<br/><br/>Letzte Spionage: '.date(GUI_Panel_Date::FORMAT_DATETIME, $newestReport->time);
			$hoverText .= '<br/>Angriffskraft: '.GUI_Panel_Number::formatNumber($att);
			$hoverText .= '<br/>Verteidigungskraft: '.GUI_Panel_Number::formatNumber($deff);
		}
		
		return $hoverText;
	}
	
	private function visibleOnLoad() {
		return (($this->map->getViewRectX() <= (int)$this->cityOwner->cityX && (int)$this->cityOwner->cityX <= $this->map->getViewRectX() + $this->map->getViewRectSize())
			&& ($this->map->getViewRectY() <= (int)$this->cityOwner->cityY && (int)$this->cityOwner->cityY <= $this->map->getViewRectY() + $this->map->getViewRectSize()));
	}
}

?>