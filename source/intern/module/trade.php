<?php

class Rakuun_Intern_Module_Trade extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
			
		$this->setPageTitle('Handeln');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/trade.tpl');
		
		$param = $this->getParam('user');
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
		
		$this->contentPanel->addPanel($tradeBox = new Rakuun_GUI_Panel_Box('trade', new Rakuun_Intern_GUI_Panel_Trade('trade', 'Handeln', $user)));
		$tradeBox->addClasses('rakuun_box_trade');
	}
}

?>