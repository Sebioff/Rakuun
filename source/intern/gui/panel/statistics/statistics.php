<?php

class Rakuun_Intern_GUI_Panel_Statistics extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/statistics.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		$table->addTableCssClass('align_left', 0);
		$table->addHeader(array('Name', 'Wert'));
		
		$line = array('Anzahl Spieler:', Text::formatNumber(Rakuun_Intern_Statistics::noOfPlayers()));
		$table->addLine($line);
		
		$nooblimit = Rakuun_Intern_Statistics::averagePoints() * 0.6;
		if ($nooblimit < RAKUUN_NOOB_START_LIMIT_OF_POINTS)
			$nooblimit = RAKUUN_NOOB_START_LIMIT_OF_POINTS;
		$line = array('Noobschutz Punktegrenze:', Text::formatNumber($nooblimit));
		$table->addLine($line);
		
		// calc armystrength
		$nooblimit = Rakuun_Intern_Statistics::averageArmyStrength() * 0.6;
		if ($nooblimit < RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH)
			$nooblimit = RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH;
		$line = array('Noobschutz Armeestärkegrenze:', Text::formatNumber($nooblimit));
		$table->addLine($line);
		
		$line = array('Anzahl Allianzen:', Text::formatNumber(Rakuun_Intern_Statistics::noOfAllies()));
		$table->addLine($line);
		
		$line = array('Anzahl Metas:', Text::formatNumber(Rakuun_Intern_Statistics::noOfMetas()));
		$table->addLine($line);
		
		$line = array('Vergebene Verwarnungspunkte:', Text::formatNumber(Rakuun_Intern_Statistics::noOfCautionPoints()));
		$table->addLine($line);
		
		$line = array('Anzahl verwarnter User:', Text::formatNumber(Rakuun_Intern_Statistics::noOfCautionedUsers()));
		$table->addLine($line);
	}

}

?>