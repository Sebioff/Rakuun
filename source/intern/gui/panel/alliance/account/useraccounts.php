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
		$logs = Rakuun_DB_Containers::getAlliancesAccountlogContainer()->select($options);
		$users = array();
		foreach ($logs as $log) {
			$user = isset($log->receiver) ? $log->receiver : $log->sender;
			if (!isset($users[$user->getPK()])) {
				$users[$user->getPK()]['sum'] = array(
						'iron' => 0,
						'beryllium' => 0,
						'energy' => 0,
						'people' => 0
					);
			}
			$users[$user->getPK()]['sum']['iron'] += $log->iron * $log->type;
			$users[$user->getPK()]['sum']['beryllium'] += $log->beryllium * $log->type;
			$users[$user->getPK()]['sum']['energy'] += $log->energy * $log->type;
			$users[$user->getPK()]['sum']['people'] += $log->people * $log->type;
			$users[$user->getPK()]['user'] = $user;
		}
		$table = new GUI_Panel_Table('table');
		$table->enableSortable();
		$table->setAttribute('summary', 'Kontobewegungen');
		$table->addHeader(array('Name', 'Eisen', 'Beryllium', 'Energie', 'Leute'));
		foreach ($users as $user) {
			$userlink = new Rakuun_GUI_Control_UserLink('moves-userlink'.$user['user']->getPK(), $user['user']);
			$iron = new GUI_Panel_Number('moves-iron'.$user['user']->getPK(), $user['sum']['iron']);
			$beryllium = new GUI_Panel_Number('moves-beryllium'.$user['user']->getPK(), $user['sum']['beryllium']);
			$energy = new GUI_Panel_Number('moves-energy'.$user['user']->getPK(), $user['sum']['energy']);
			$people = new GUI_Panel_Number('moves-people'.$user['user']->getPK(), $user['sum']['people']);
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