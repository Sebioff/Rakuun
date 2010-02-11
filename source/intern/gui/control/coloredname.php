<?php

class Rakuun_Intern_GUI_Control_ColoredName extends GUI_Control_TextBox {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user, $title = '') {
		parent::__construct($name, $user->nameColored, $title);
		
		$this->user = $user;
	}
	
	protected function validate() {	
		parent::validate();
		
		if ($this->getValue() && !$this->user->validName($this->getValue()))
			$this->errors[] = 'Ungültiger Nickname';
		
		return $this->errors;
	}
}

?>