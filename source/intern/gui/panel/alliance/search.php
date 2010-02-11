<?php

/**
 * Panel to search the list of alliances.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Search extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Name / Tag'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Suchen'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		$searchFor = '%'.str_replace('*', '%', $this->name).'%';
		$alliances = Rakuun_DB_Containers::getAlliancesContainer()->select(array('conditions' => array(array('name LIKE ? OR tag LIKE ?', $searchFor, $searchFor))));
		$this->params->alliances = $alliances;
	}
}

?>