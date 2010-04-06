<?php

/**
 * Panel to display the user accounts
 */
class Rakuun_Intern_GUI_Panel_Alliance_Account_UserAccounts extends GUI_Panel {
	public function init() {
		parent::init();
		
		$options = array();
		$options['order'] = 'date DESC';
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$options['conditions'][] = array('sender != ?', 'NULL');
		$logs = Rakuun_DB_Containers::getAlliancesAccountlogContainer()->select($options);
		$users = array();
		foreach ($logs as $log) {
			$user = isset($log->receiver) ? $log->receiver : $log->sender;
			$pk = $user ? $user->getPK() : 0;
			if (!isset($users[$pk])) {
				$users[$pk]['sum'] = array(
						'iron' => 0,
						'beryllium' => 0,
						'energy' => 0,
						'people' => 0
					);
			}
			$users[$pk]['sum']['iron'] += $log->iron * $log->type;
			$users[$pk]['sum']['beryllium'] += $log->beryllium * $log->type;
			$users[$pk]['sum']['energy'] += $log->energy * $log->type;
			$users[$pk]['sum']['people'] += $log->people * $log->type;
			$users[$pk]['user'] = $user;
		}
		$table = new GUI_Panel_Table('table');
		$table->enableSortable();
		$table->setAttribute('summary', 'Kontobewegungen');
		$table->addHeader(array('Name', 'Eisen', 'Beryllium', 'Energie', 'Leute'));
		foreach ($users as $user) {
			$pk = $user['user'] ? $user['user']->getPK() : 0;
			$userlink = new Rakuun_GUI_Control_UserLink('moves-userlink'.$pk, $user['user']);
			$iron = new GUI_Panel_Number('moves-iron'.$pk, $user['sum']['iron']);
			$beryllium = new GUI_Panel_Number('moves-beryllium'.$pk, $user['sum']['beryllium']);
			$energy = new GUI_Panel_Number('moves-energy'.$pk, $user['sum']['energy']);
			$people = new GUI_Panel_Number('moves-people'.$pk, $user['sum']['people']);
			$table->addLine(array($userlink, $iron, $beryllium, $energy, $people));
		}
		$sorterheaders = array();
		for ($i = 1; $i <= $table->getColumnCount(); $i++) {
			$sorterheaders[] = $i.': { sorter: \'separatedDigit\' }';
		}
		$table->addSorterOption('headers: { '.implode(', ', $sorterheaders).' }');
		$this->addPanel($table);
	}
}

?>