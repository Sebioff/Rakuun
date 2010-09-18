<?php

/**
 * Panel to display the User Highscore.
 */
class Rakuun_Intern_GUI_Panel_User_Highscore extends GUI_Panel_PageView {
	public function __construct($name, DB_Container $userContainer, $title = '') {
		$options['order'] = 'points DESC';
		$options['conditions'][] = array('last_login > 0');
		$users = $userContainer->getFilteredContainer($options);
		parent::__construct($name, $users, $title);
		$this->setItemsPerPage(25);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/highscore.tpl');
		$this->addPanel($table = new GUI_Panel_Table('highscore'));
		$table->addHeader(array('Rang', 'Name', 'Allianz', 'Punkte'));
		$table->addTableCssClass('align_right', 3);
		$users = $this->getContainer()->select($this->getOptions());
		$i = 1 + (($this->getPage() - 1) * $this->getItemsPerPage());
		foreach ($users as $user) {
			$line = array();
			$line[] = $i;
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$i, $user);
			$line[] = $user->alliance ? new Rakuun_GUI_Control_AllianceLink('useralliancelink'.$i, $user->alliance) : '';
			$line[] = new GUI_Panel_Number('userpoints'.$i, $user->points);
			$table->addLine($line);
			$i++;
		}
		$table->setAttribute('summary', 'User Highscore');
	}
}

?>