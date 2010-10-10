<?php

/**
 * Displays all Userdata changes of a given user
 */
class Rakuun_Intern_GUI_Panel_Multihunting_Multiscore extends GUI_Panel_PageView {
	public function __construct($name, DB_Container $userContainer, $title = '') {
		$options['order'] = 'multi_points DESC';
		$options['conditions'][] = array('multi_points > 0');
		$users = $userContainer->getFilteredContainer($options);
		parent::__construct($name, $users, $title);
		$this->setItemsPerPage(25);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/multiscore.tpl');
		$this->addPanel($table = new GUI_Panel_Table('multiscore'));
		$table->addHeader(array('Rang', 'Name', 'Allianz', 'Multipunkte'));
		$table->addTableCssClass('align_right', 3);
		$users = $this->getContainer()->select($this->getOptions());
		$i = 1 + (($this->getPage() - 1) * $this->getItemsPerPage());
		foreach ($users as $user) {
			$line = array();
			$line[] = $i;
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$i, $user);
			$line[] = $user->alliance ? new Rakuun_GUI_Control_AllianceLink('useralliancelink'.$i, $user->alliance) : '';
			$line[] = new Rakuun_GUI_Control_MultiLogLink('multilink'.$i, $user, $user->multiPoints);
			$table->addLine($line);
			$i++;
		}
		$table->setAttribute('summary', 'Multiscore');
	}
}

?>