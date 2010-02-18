<?php

/**
 * Panel which displays a button to leave a meta.
 */
class Rakuun_Intern_GUI_Panel_Meta_Leave extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/leave.tpl');
		$this->addPanel($button = new GUI_Control_SecureSubmitButton('leave', 'Verlassen'));
		$button->setConfirmationMessage('Wollt ihr die Meta wirklich verlassen?');
	}
	
	public function onLeave() {
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		if (Rakuun_DB_Containers::getAlliancesContainer()->countByMeta($alliance->meta) == 1) {
			//delete meta after last alliance left
			Rakuun_DB_Containers::getMetasContainer()->delete($alliance->meta);
		}
		$alliance->meta = null;
		Rakuun_DB_Containers::getAlliancesContainer()->save($alliance);
		DB_Connection::get()->commit();
		$this->getModule()->redirect(App::get()->getInternModule()->getURL());
	}
}

?>