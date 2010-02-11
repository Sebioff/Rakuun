<?php

class Rakuun_Intern_GUI_Panel_Production_ProducedList extends Rakuun_GUI_Panel_Box_Collapsible {
	private $user = null;
	private $producedItems = array();
	
	public function __construct($name, array $producedItems, $user = null, $title = '') {
		parent::__construct($name, null, $title);
		
		$this->producedItems = $producedItems;
		
		if (!$user)
			$user = Rakuun_User_Manager::getCurrentUser();
		$this->user = $user;
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/producedlist.tpl');
		$this->contentPanel->params->producedItems = $this->producedItems;
	}
}

?>