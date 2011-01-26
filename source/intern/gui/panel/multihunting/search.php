<?php

/**
 * Search the Activitylog.
 */
class Rakuun_Intern_GUI_Panel_Multihunting_Search extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Username'));
		$this->addPanel($ip = new GUI_Control_TextBox('ip', null, 'IP'));
		$this->addPanel($hostname = new GUI_Control_TextBox('hostname', null, 'Hostname'));
		$this->addPanel($browser = new GUI_Control_TextBox('browser', null, 'Browser'));
		$this->addPanel($email = new GUI_Control_TextBox('email', null, 'Email'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Suchen'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;

		$options = array();
		//$options['conditions'][] = array('name LIKE ?', '%'.str_replace('*', '%', $this->name).'%');
		$options['conditions'][] = array('ip LIKE ?', '%'.str_replace('*', '%', $this->ip).'%');
		$options['conditions'][] = array('hostname LIKE ?', '%'.str_replace('*', '%', $this->hostname).'%');
		$options['conditions'][] = array('browser LIKE ?', '%'.str_replace('*', '%', $this->browser).'%');
		//$options['conditions'][] = array('email LIKE ?', '%'.str_replace('*', '%', $this->name).'%');
		$options['order'] = 'user ASC';
		$logs = Rakuun_DB_Containers::getLogUserActivityContainer()->select($options);
		$this->params->logs = $logs;
	}
}

?>