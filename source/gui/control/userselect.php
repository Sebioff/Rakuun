<?php

class Rakuun_GUI_Control_UserSelect extends GUI_Control_TextBox {
	public function __construct($name, Rakuun_DB_User $defaultValue = null, $title = '') {
		parent::__construct($name, $defaultValue ? $defaultValue->nameUncolored : null, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->getModule()->addJsRouteReference('js', 'control/autocomplete/jquery.autocomplete.js');
		$this->getModule()->addCssRouteReference('css', 'control/autocomplete/jquery.autocomplete.css');
	}
	
	protected function validate() {
		parent::validate();
		
		if ($error = $this->validation())
			$this->errors[] = $error;
		
		return $this->errors;
	}
	
	/**
	 * @return Rakuun_DB_User
	 */
	public function getUser() {
		return Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->getValue());
	}
	
	public function render() {
		$this->addJS($this->generateJS());
		return parent::render();
	}
	
	protected function generateJS() {
		return sprintf('$("#%s").autocomplete("%s", {width: 260, autoFill: true, max: 10});', $this->getID(), App::get()->getUserSelectScriptletModule()->getURL());
	}
	
	protected function validation() {
		if ($this->getValue()) {
			if (!$this->getUser())
				$this->errors[] = 'Spieler existiert nicht: '.$this->getValue();
		}
	}
}

class Rakuun_GUI_Control_UserSelect_Scriptlet extends Scriptlet {
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('name LIKE ?', $this->getParam('q').'%');
		if ($this->getParam('limit') !== null)
			$options['limit'] = $this->getParam('limit');
		foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $user) {
			echo $user->nameUncolored."\n";
		}
	}
}

?>