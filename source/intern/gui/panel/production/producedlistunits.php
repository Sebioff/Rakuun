<?php

class Rakuun_Intern_GUI_Panel_Production_ProducedListUnits extends Rakuun_Intern_GUI_Panel_Production_ProducedList {
	public function __construct($name, array $producedItems, $user = null, $title = '') {
		parent::__construct($name, $producedItems, $user, $title);
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/producedlistunits.tpl');
	}
}

?>