<?php

class Rakuun_GUI_Panel_Box_Collapsible extends Rakuun_GUI_Panel_Box {
	private $enableAjax = true;
	private $enableSaveCollapsedState = true;
	private $collapsed = null; // read only, use isCollapsed() to check state
	private $animationSpeed;
	
	public function __construct($name, GUI_Panel $contentPanel = null, $title = '', $collapsed = null, $enableAjax = true) {
		parent::__construct($name, $contentPanel, $title);
		
		$this->addClasses('rakuun_box_collapsible');
		$this->enableAjax = $enableAjax;
		$this->collapsed = $collapsed;
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
		
		$this->addJS(sprintf('box = new GUI_Control_Box_Collapsible("%s", "%s", "%s");', $this->getID(), $this->enableSaveCollapsedState, $this->enableAjax));
		if ($this->animationSpeed)
			$this->addJS('box.setAnimationSpeed('.$this->animationSpeed.');');
		
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
		if ($this->collapsed === null) {
			$collapsedPanels = explode('|', Rakuun_User_Manager::getCurrentUser()->collapsedPanels);
			$this->collapsed = (in_array($this->getID(), $collapsedPanels));
		}
		
		if ($this->enableAjax && Router::get()->getRequestMode() == Router::REQUESTMODE_AJAX
		&& ((isset($_POST['core_ajax_panel']) && $_POST['core_ajax_panel'] == $this->getID()) || ($_POST['core_ajax_method'] == 'display' && in_array($this->getID(), explode(',', $_POST['refreshPanels'])))))
			$this->collapsed = false;
		
		return $this->collapsed;
	}
	
	public function enableSaveCollapsedState($enableSaveCollapsedState = true) {
		$this->enableSaveCollapsedState = $enableSaveCollapsedState;
	}
	
	public function setAnimationSpeed($animationSpeed) {
		$this->animationSpeed = $animationSpeed;
	}
}

?>