<?php

/**
 * Panel to view the ressources of any alliance member
 */
class Rakuun_Intern_GUI_Panel_Alliance_Statistic_Ressources extends GUI_Panel {
	private $alliance = null;
	
	public function __construct($name, $alliance = null, $title = '') {
		$this->alliance = $alliance ? $alliance : Rakuun_User_Manager::getCurrentUser()->alliance;
		parent::__construct($name, $title);
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->getModule()->addJsRouteReference('js', 'sorters.js');
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/ressources.tpl');
		$this->addPanel($table = new GUI_Panel_Table('ressources', 'Ressourcen'));
		$options['join'] = array('users');
		$options['conditions'][] = array('ressources.user = users.id');
		$options['conditions'][] = array('users.alliance = ?', $this->alliance);
		$ressources = Rakuun_DB_Containers::getRessourcesContainer()->select($options);
		$table->enableSortable();
		$table->addHeader(array('', 'Eisen', 'Beryllium', 'Energie', 'Leute'));
		$summe['iron'] = 0;
		$summe['beryllium'] = 0;
		$summe['energy'] = 0;
		$summe['people'] = 0;
		foreach ($ressources as $ressource) {
			$table->addLine(
				array(
					new Rakuun_GUI_Control_UserLink('user'.$ressource->user->getPK(), $ressource->user),
					GUI_Panel_Number::formatNumber($ressource->iron),
					GUI_Panel_Number::formatNumber($ressource->beryllium),
					GUI_Panel_Number::formatNumber($ressource->energy),
					GUI_Panel_Number::formatNumber($ressource->people)
				)
			);
			$summe['iron'] += $ressource->iron;
			$summe['beryllium'] += $ressource->beryllium;
			$summe['energy'] += $ressource->energy;
			$summe['people'] += $ressource->people;
		}
		$table->addFooter(
			array(
				'Summe:',
				GUI_Panel_Number::formatNumber($summe['iron']),
				GUI_Panel_Number::formatNumber($summe['beryllium']),
				GUI_Panel_Number::formatNumber($summe['energy']),
				GUI_Panel_Number::formatNumber($summe['people'])
			)
		);
		$table->addFooter(
			array(
				'Durchschnitt:',
				GUI_Panel_Number::formatNumber($summe['iron'] / count($ressources)),
				GUI_Panel_Number::formatNumber($summe['beryllium'] / count($ressources)),
				GUI_Panel_Number::formatNumber($summe['energy'] / count($ressources)),
				GUI_Panel_Number::formatNumber($summe['people'] / count($ressources))
			)
		);
		$table->setAttribute('summary', 'Ressourcenübersicht der Allianz '.$this->alliance->name);
		$sorterheaders = array(
			'0: { sorter: \'username\' }',
			'1: { sorter: \'separatedDigit\' }',
			'2: { sorter: \'separatedDigit\' }',
			'3: { sorter: \'separatedDigit\' }',
			'4: { sorter: \'separatedDigit\' }'
		);
		$table->addSorterOption('headers: { '.implode(', ', $sorterheaders).' }');
	}
	
	public function getAlliance() {
		return $this->alliance;
	}
}

?>