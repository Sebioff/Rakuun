<?php
/**
 * Panel to search the list of metas.
 */
class Rakuun_Intern_GUI_Panel_Meta_Search extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Name'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Suchen'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;

		$metas = Rakuun_DB_Containers::getMetasContainer()->select(array('conditions' => array(array('name LIKE ?', '%'.$this->name.'%'))));
		$this->params->metas = $metas;
	}
}

?>