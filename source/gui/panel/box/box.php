<?php

class Rakuun_GUI_Panel_Box extends GUI_Panel {
	protected $contentPanel = null;
	
	public function __construct($name, GUI_Panel $contentPanel = null, $title = '') {
		parent::__construct($name, $title);
		
		if (!$contentPanel)
			$contentPanel = new Rakuun_GUI_Panel_Box_Content('content_panel', $this);

		$this->addPanel($contentPanel);
		$this->contentPanel = $contentPanel;
		$this->contentPanel->addClasses('rakuun_box_content');
		$this->setTemplate(dirname(__FILE__).'/box.tpl');
		$this->addClasses('rakuun_box');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getContentPanel() {
		return $this->contentPanel;
	}
	
	public function setContentPanel(GUI_Panel $contentPanel) {
		$this->contentPanel = $contentPanel;
	}
}

// -----------------------------------------------------------------------------

class Rakuun_GUI_Panel_Box_Content extends GUI_Panel {
	private $parent = null;
	
	public function __construct($name, Rakuun_GUI_Panel_Box $parent) {
		parent::__construct($name);
		
		$this->parent = $parent;
	}
	
	public function __call($name, $params) {
		return call_user_func_array(array($this->parent, $name), $params);
	}
}

?>