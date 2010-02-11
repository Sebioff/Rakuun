<?php

class Rakuun_Intern_GUI_Panel_Techtree_Item extends GUI_Panel {
	private $productionItem = null;
	
	public function __construct($name, Rakuun_Intern_Production_Base $productionItem) {
		parent::__construct($name);
		$this->productionItem = $productionItem;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/item.tpl');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_Intern_Production_Base
	 */
	public function getProductionItem() {
		return $this->productionItem;
	}
}

?>