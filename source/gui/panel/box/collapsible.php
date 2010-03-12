<?php

class Rakuun_GUI_Panel_Box_Collapsible extends Rakuun_GUI_Panel_Box {
	public function __construct($name, GUI_Panel $contentPanel = null, $title = '') {
		parent::__construct($name, $contentPanel, $title);
		
		$this->addClasses('rakuun_box_collapsible');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->addJS(sprintf('new GUI_Control_Box_Collapsible("%s", "%s");', App::get()->getPanelCollapseModule()->getURL(), $this->getID()));
		
		$collapsedPanels = explode('|', Rakuun_User_Manager::getCurrentUser()->collapsedPanels);
		if (in_array($this->getID(), $collapsedPanels))
			$this->addClasses('collapsed');
	}
}

// -----------------------------------------------------------------------------

class Rakuun_GUI_Panel_Box_Collapsible_Ajax extends Scriptlet {
	public function init() {
		parent::init();
		
		$panel = $this->getParam('panel');
		$user = Rakuun_User_Manager::getCurrentUser();
		$collapsedPanels = explode('|', $user->collapsedPanels);
		if ($key = array_search($panel, $collapsedPanels)) {
			unset($collapsedPanels[$key]);
			$user->collapsedPanels = implode('|', $collapsedPanels);
			Rakuun_User_Manager::update($user);
		}
		else {
			$collapsedPanels[] = $panel;
			$user->collapsedPanels = implode('|', $collapsedPanels);
			Rakuun_User_Manager::update($user);
		}
	}
}

?>