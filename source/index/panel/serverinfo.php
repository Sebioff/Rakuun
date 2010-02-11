<?php

class Rakuun_Index_Panel_Serverinfo extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/serverinfo.tpl');
		
		if (RAKUUN_ROUND_STARTTIME > time()) {
			$this->addPanel(new Rakuun_GUI_Panel_CountDown('start_countdown', RAKUUN_ROUND_STARTTIME, 'nicht angemeldet? ;)'));
		}
	}
}

?>