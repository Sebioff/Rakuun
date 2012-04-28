<?php

/**
 * Panel to display the meta alliance accounts
 */
class Rakuun_Intern_GUI_Panel_Meta_Account_AllianceAccounts extends GUI_Panel_PageView {
	
	public function __construct($name, $title = '') {
		$options['conditions'][] = array('meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
		$logs = Rakuun_DB_Containers::getMetasAccountlogContainer()->getFilteredContainer($options);
		parent::__construct($name, $logs, $title);
		
		$this->setItemsPerPage(20);
	}
	
	public function init() {
		parent::init();
		
		$options['order'] = 'date DESC';
		$logs = $this->getContainer()->select(array_merge($options, $this->getOptions()));
		$alliances = array();
		foreach ($logs as $log) {
			if ($log->alliance) { //hotfix: if alliance is deleted
				if (!isset($alliances[$log->alliance->getPK()])) {
					$alliances[$log->alliance->getPK()]['sum'] = array(
							'iron' => 0,
							'beryllium' => 0,
							'energy' => 0,
							'people' => 0
						);
				}
				$alliances[$log->alliance->getPK()]['sum']['iron'] += $log->iron;
				$alliances[$log->alliance->getPK()]['sum']['beryllium'] += $log->beryllium;
				$alliances[$log->alliance->getPK()]['sum']['energy'] += $log->energy;
				$alliances[$log->alliance->getPK()]['sum']['people'] += $log->people;
				$alliances[$log->alliance->getPK()]['alliance'] = $log->alliance;
			}
		}
		$table = new GUI_Panel_Table('table');
		$table->setAttribute('summary', 'Kontobewegungen');
		$table->addHeader(array('Allianz', 'Eisen', 'Beryllium', 'Energie', 'Leute'));
		foreach ($alliances as $alliance) {
			$alliancelink = new Rakuun_GUI_Control_AllianceLink('moves_alliancelink'.$alliance['alliance']->getPK(), $alliance['alliance']);
			$iron = new GUI_Panel_Number('moves_iron'.$alliance['alliance']->getPK(), $alliance['sum']['iron']);
			$beryllium = new GUI_Panel_Number('moves_beryllium'.$alliance['alliance']->getPK(), $alliance['sum']['beryllium']);
			$energy = new GUI_Panel_Number('moves_energy'.$alliance['alliance']->getPK(), $alliance['sum']['energy']);
			$people = new GUI_Panel_Number('moves_people'.$alliance['alliance']->getPK(), $alliance['sum']['people']);
			$table->addLine(array($alliancelink, $iron, $beryllium, $energy, $people));
		}
		$this->addPanel($table);
	}
}

?>