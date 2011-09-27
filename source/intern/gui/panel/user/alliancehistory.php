<?php

/*
 * Shows all Allianceactivities (e.g. join, kick, application, ...) of a user
 */
class Rakuun_Intern_GUI_Panel_User_AllianceHistory extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user) {
		parent::__construct($name, 'Allianzhistory');
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/alliancehistory.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('alliancehistory', 'Allianzhistory'));
		$table->addHeader(array('Allianz', 'Aktivität', 'Datum'));
		$type = Rakuun_Intern_Alliance_History::getMessageTypes();
		
		$options['conditions'][] = array('user = ?', $this->user->id);
		$options['order'] = 'date DESC';
		$allianceactivities = Rakuun_DB_Containers::getAllianceHistoryContainer()->select($options);
		foreach ($allianceactivities as $allianceactivity) {
			$table->addLine(array($allianceactivity->allianceName, $type[$allianceactivity->type], date('d.m.Y, H:i:s', $allianceactivity->date)));
		}
	}

}

?>