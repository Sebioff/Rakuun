<?php

/**
 * Panel to view the ressources of any alliance member
 */
class Rakuun_Intern_GUI_Panel_Alliance_Statistic_Army extends GUI_Panel {
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
		
		$this->setTemplate(dirname(__FILE__).'/army.tpl');
		$this->addPanel($table = new GUI_Panel_Table('army', 'Armeen'));
		$table->enableSortable();
		$users = $this->alliance->members;
		$header = array('');
		$summe = array();
		foreach ($users as $user) {
			$units = Rakuun_Intern_Production_Factory::getAllUnits($user);
			$i = 0;
			$line = array(new Rakuun_GUI_Control_UserLink('user'.$user->getPK(), $user));
			$att = 0;
			$deff = 0;
			$header[++$i] = 'Online';
			$online = new GUI_Panel_Text('online'.$user->getPK(), $user->isOnline() ? 1 : 0);
			$online->addClasses($user->isOnline() ? 'user_online' : 'user_offline');
			$line[] = $online;
			$summe['online'] = '';
			foreach ($units as $unit) {
				if (!isset($summe[$unit->getInternalName()]))
					$summe[$unit->getInternalName()] = 0;
				$atHome = $unit->getAmount();
				$atBuild = $unit->getAmountInProduction();
				if (!$unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY))
					$notAtHome = $unit->getAmountNotAtHome();
				else
					$notAtHome = 0;
				$summe[$unit->getInternalName()] += $atHome + $atBuild + $notAtHome;
				$header[++$i] = $unit->getNamePlural();
				$lineText = GUI_Panel_Number::formatNumber($atHome);
				if ($atBuild > 0)
					$lineText .= ' (+'.GUI_Panel_Number::formatNumber($atBuild).')';
				if (!$unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY))
					$lineText .= ' / '.GUI_Panel_Number::formatNumber($notAtHome);
				$line[$unit->getInternalName()] = $lineText;
				$att += $unit->getAttackValue();
				$deff += $unit->getDefenseValue();
			}
			$header[++$i] = 'Stadtmauer';
			$line[] = $user->buildings->cityWall;
			$summe['Stadtmauer'] = '';
			$header[++$i] = 'Laser';
			$line[] = $user->technologies->laser;
			$summe['Laser'] = '';
			$header[++$i] = 'Att';
			$line[] = GUI_Panel_Number::formatNumber($att);
			if (!isset($summe['att']))
				$summe['att'] = 0;
			$summe['att'] += $att;
			$header[++$i] = 'Deff';
			$line[] = GUI_Panel_Number::formatNumber($deff);
			if (!isset($summe['deff']))
				$summe['deff'] = 0;
			$summe['deff'] += $deff;
			$header[++$i] = 'Punkte';
			$line[] = GUI_Panel_Number::formatNumber($user->points);
			if (!isset($summe['points']))
				$summe['points'] = 0;
			$summe['points'] += $user->points;
			$header[++$i] = 'Karte';
			$line[] = new Rakuun_GUI_Control_MapLink('koords'.$user->getPK(), $user);
			$summe['map'] = '';
			$table->addLine($line);
		}
		$table->addHeader($header);
		$table->addFooter(
			array_merge(
				array('Summe:'),
				array_map(
					create_function('$item', 'return is_numeric($item) ? GUI_Panel_Number::formatNumber($item) : $item;'),
					$summe
				)
			)
		);
		$sorterheaders = array(
			'0: { sorter: \'username\' }',			//username
			'1: { sorter: \'digit\' }',				//online/offline
			'2: { sorter: \'army\' }',				//Pezettos
			'3: { sorter: \'army\' }',				//Inras
			'4: { sorter: \'army\' }',				//Laserschützen
			'5: { sorter: \'army\' }',				//Tegos
			'6: { sorter: \'army\' }',				//Miniganis
			'7: { sorter: \'army\' }',				//Mandroganis
			'8: { sorter: \'army\' }',				//Buhoganis
			'9: { sorter: \'army\' }',				//Donanies
			'10: { sorter: \'army\' }',				//Tertoren
			'11: { sorter: \'army\' }',				//Stormoks
			'12: { sorter: \'army\' }',				//Lasertürme
			'13: { sorter: \'army\' }',				//Telaturris
			'14: { sorter: \'army\' }',				//Spionagesonden
			'15: { sorter: \'army\' }',				//Tarnsonden
			'16: { sorter: \'army\' }',				//Loricas
			'17: { sorter: \'separatedDigit\' }',	//Stadtmauer
			'18: { sorter: \'separatedDigit\' }',	//Laser
			'19: { sorter: \'separatedDigit\' }',	//Att
			'20: { sorter: \'separatedDigit\' }',	//Deff
			'21: { sorter: \'separatedDigit\' }',	//Punkte
			'22: { sorter: \'mapkoords\' }'			//Karte
		);
		$table->addSorterOption('headers: { '.implode(', ', $sorterheaders).' }');
		$table->addFooter(
			array_merge(
				array('Durchschnitt:'),
				array_map(
					create_function('$item', 'return is_numeric($item) ? GUI_Panel_Number::formatNumber($item / '.count($users).') : $item;'),
					$summe
				)
			)
		);
		$table->setAttribute('summary', 'Armeenübersicht der Allianz '.$this->alliance->name);
	}
}

?>