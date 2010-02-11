<?php

class Rakuun_Intern_Module_FightDetails extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Kampfinformationen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/fightdetails.tpl');
		
		$army = Rakuun_DB_Containers::getArmiesContainer()->selectByPK($this->getParam('id'));
		if ($army->user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK())
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('details', new Rakuun_Intern_GUI_Panel_Map_Fights_Details('details', $army), 'Kampfdetails'));
	}
}

?>