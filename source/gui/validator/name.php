<?php

/**
 * Ensures there are no funky characters, for example whitespaces, in a name
 */
class Rakuun_GUI_Validator_Name extends GUI_Validator {
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function isValid() {
		return (trim($this->control->getValue()) == $this->control->getValue());
	}
	
	public function getError() {
		return 'Ungültiger Name (Leerzeichen am Anfang/Ende)';
	}
}

?>