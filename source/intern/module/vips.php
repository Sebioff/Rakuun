<?php

/**
 * A Module for displaying all VIPs in this Game
 * @author dr.dent
 */
class Rakuun_Intern_Module_VIPs extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
			
		$this->setPageTitle('VIPs');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/vips.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('vips', new Rakuun_Intern_GUI_Panel_User_VIPs('vips', 'wichtige Personen')));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('winners', new Rakuun_Intern_GUI_Panel_User_RoundWinners('winners'), 'Frühere Rundensieger'));
	}
}

?>