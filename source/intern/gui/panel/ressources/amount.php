<?php

class Rakuun_Intern_GUI_Panel_Ressources_Amount extends GUI_Panel_Number {
	private $productionRate = 0;
	private $limit = 0;
	
	public function __construct($name, $amount, $productionRate, $limit, $title = '') {
		parent::__construct($name, $amount, $title);
		
		$this->productionRate = $productionRate;
		$this->limit = $limit;
	}
	
	public function init() {
		parent::init();
		
		$this->getModule()->addJsRouteReference('js', 'panel/ressources.js');
	}
	
	public function afterInit() {
		parent::afterInit();
		if ($this->productionRate > 0 && $this->text < $this->limit)
			$this->addJS('new GUI_Control_Ressources("'.$this->getID().'", '.$this->text.', '.$this->productionRate.', '.$this->limit.');');
	}
	
	public function getText() {
		return Text::formatNumber($this->text, 0);
	}
}

?>