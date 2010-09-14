<?php

class Rakuun_Index_Panel_Endscore_BiggestRaids extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/biggestraids.tpl');
		
		$options = array();
		$options['properties'] = 'user, sender, time, iron, beryllium, energy';
		$options['order'] = 'iron + beryllium + energy DESC';
		$options['limit'] = '20';
		$this->params->raids = Rakuun_DB_Containers_Persistent::getLogUserRessourcetransferContainer()->select($options);
	}
}

?>