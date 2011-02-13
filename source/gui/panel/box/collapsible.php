<?php

class Rakuun_GUI_Panel_Box_Collapsible extends Rakuun_GUI_Panel_Box {
	private $enableAjax = true;
	
	public function __construct($name, GUI_Panel $contentPanel = null, $title = '', $enableAjax = true) {
		parent::__construct($name, $contentPanel, $title);
		
		$this->addClasses('rakuun_box_collapsible');
		$this->enableAjax = $enableAjax;
	}
	
	public function init() {
		if (!$this->enableAjax || !$this->isCollapsed())
			parent::init();
	}
	
	public function addPanel(GUI_Panel $panel, $toBeginning = false) {
		if (!$this->enableAjax || !$this->isCollapsed())
			parent::addPanel($panel, $toBeginning);
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->addJS(sprintf('new GUI_Control_Box_Collapsible("%s", "%s");', $this->getID(), $this->enableAjax));
		
		if ($this->isCollapsed())
			$this->addClasses('collapsed');
	}
	
	public function ajaxCollapse() {
		$panel = $_POST['core_ajax_panel'];
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
	
	public function isCollapsed() {
		$collapsedPanels = explode('|', Rakuun_User_Manager::getCurrentUser()->collapsedPanels);
		return (in_array($this->getID(), $collapsedPanels));
	}
}

?>