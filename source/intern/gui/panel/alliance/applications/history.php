<?php

/**
 * View all the applications sent to your alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Applications_History extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/history.tpl');
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$options['conditions'][] = array('status != ?', Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_NEW);
		$options['order'] = 'date DESC';
		$applications = Rakuun_DB_Containers::getAlliancesApplicationsContainer()->select($options);
		$this->addPanel($table = new GUI_Panel_Table('historytable'));
		$table->setAttribute('summary', 'Übersicht über bearbeitete Bewerbungen bei dieser Allianz.');
		$table->addHeader(array('Datum', 'Name', 'Status', 'Bearbeitet durch', 'Bewerbungstext', 'Ablehnungsgrund'));
		foreach ($applications as $application) {
			$line = array();
			$line[] = new GUI_Panel_Date('date'.$application->getPK(), $application->date);
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$application->getPK(), $application->user);
			switch ($application->status) {
				case Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_FIRED:
					$line[] = 'Abgelehnt';
					$line[] = new Rakuun_GUI_Control_UserLink('editorlink'.$application->getPK(), $application->editor);
					$line[] = $application->text;
					$line[] = $application->editorNotice;
				break;
				case Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_HIRED:
					$line[] = 'Angenommen';
					$line[] = new Rakuun_GUI_Control_UserLink('editorlink'.$application->getPK(), $application->editor);
					$line[] = $application->text;
					$line[] = '';
				break;
				case Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_JOINED_OTHER:
					$line[] = 'ist einer anderen Allianz beigetreten';
					$line[] = '';
					$line[] = $application->text;
					$line[] = '';
				break;
			}
			$table->addLine($line);
		}
	}
}
?>