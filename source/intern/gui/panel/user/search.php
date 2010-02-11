<?php

/**
 * Searches Usernames
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_User_Search extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Username'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Suchen'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;

		$options = array();
		$options['conditions'][] = array('name LIKE ?', '%'.str_replace('*', '%', $this->name).'%');
		$options['order'] = 'name ASC';
		$users = Rakuun_DB_Containers::getUserContainer()->select($options);
		$this->params->users = $users;
	}
}

?>