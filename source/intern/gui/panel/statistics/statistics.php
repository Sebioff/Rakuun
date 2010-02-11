<?php

class Rakuun_Intern_GUI_Panel_Statistics extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/statistics.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		
		$table->addHeader(array('Name', 'Wert'));
		
		$line = array('Anzahl Spieler:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::noOfPlayers()));
		$table->addLine($line);
		
		$line = array('Durchschnittliche Punktzahl:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::averagePoints()));
		$table->addLine($line);
		
		$line = array('Durchschnittliche Armeestärke:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::averageArmyStrength()));
		$table->addLine($line);
		
		$line = array('Anzahl Allianzen:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::noOfAllies()));
		$table->addLine($line);
		
		$line = array('Anzahl Metas:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::noOfMetas()));
		$table->addLine($line);
		
		$line = array('Vergebene Verwarnungspunkte:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::noOfCautionPoints()));
		$table->addLine($line);
		
		$line = array('Anzahl verwarnter User:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::noOfCautionedUsers()));
		$table->addLine($line);
	}

}

?>