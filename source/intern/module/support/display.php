<?php

class Rakuun_Intern_Module_Support_Display extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$id = (int)$this->getParam('id');
		$supportticket = Rakuun_DB_Containers::getSupportticketsContainer()->selectByPK($id);
		if (!$supportticket) {
			$this->redirect($this->getParent()->getUrl());
		}
		
		$this->setPageTitle('Nachricht');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/display.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_Categories('categories', 'Nachrichtenkategorien'));
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_Ticket('supportticket', $supportticket));
		if ($supportticket) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('answer', new Rakuun_Intern_GUI_Panel_Support_Answer('answer', $supportticket)), 'Antwort schreiben');
		}
	}
}

?>