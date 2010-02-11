<?php

/**
 * Panel to display the Alliance Highscore.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Highscore extends GUI_Panel_PageView {
	
	public function __construct($name, $title = '') {
		$options['order'] = 'points DESC';
		$alliances = Rakuun_DB_Containers::getAlliancesContainer()->getFilteredContainer($options);
		parent::__construct($name, $alliances, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/highscore.tpl');
		$this->addPanel($table = new GUI_Panel_Table('highscore'));
		$table->addHeader(array('Rang', 'Name', 'Meta', 'Punkte', 'Durchschnitt'));
		$alliances = $this->getContainer()->select($this->getOptions());
		$i = 1;
		foreach ($alliances as $alliance) {
			$line = array();
			$line[] = $i;
			$line[] = new Rakuun_GUI_Control_AllianceLink('alliancelink'.$i, $alliance);
			$line[] = $alliance->meta ?
				new Rakuun_GUI_Control_MetaLink('alliancemetalink'.$i, $alliance->meta) :
				'';
			$line[] = new GUI_Panel_Number('alliancepoints'.$i, $alliance->points);
			$number = new GUI_Panel_Number('allianceaverage'.$i, $alliance->points / count($alliance->members));
			$number->setPrefix('&oslash; ');
			$line[] = $number;
			$table->addLine($line);
			$i++;
		}
		$table->setAttribute('summary', 'Allianzen Highscore');
	}
}
?>