<?php

class Rakuun_Intern_GUI_Panel_Production_WIP_Alliance extends Rakuun_Intern_GUI_Panel_Production_WIP {
	public function __construct($name, Rakuun_Intern_Production_Producer $producer, $title = '') {
		parent::__construct($name, $producer, $title);
		
		$this->contentPanel->removePanel($this->contentPanel->cancel);
	}
}

?>