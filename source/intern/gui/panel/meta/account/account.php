<?php

/**
 * Panel to display the meta account
 */
class Rakuun_Intern_GUI_Panel_Meta_Account extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		//need to do this, cause meta container from user->alliance were not updated after deposit
		$meta = Rakuun_DB_Containers::getMetasContainer()->selectByIdFirst(Rakuun_User_Manager::getCurrentUser()->alliance->meta);
		$this->setTemplate(dirname(__FILE__).'/account.tpl');
		$this->addPanel($iron = new GUI_Panel_Number('iron', $meta->iron));
		$iron->setTitle('Eisen:');
		$this->addPanel($beryllium = new GUI_Panel_Number('beryllium', $meta->beryllium));
		$beryllium->setTitle('Beryllium:');
		$this->addPanel($energy = new GUI_Panel_Number('energy', $meta->energy));
		$energy->setTitle('Energie:');
		$this->addPanel($people = new GUI_Panel_Number('people', $meta->people));
		$people->setTitle('Leute:');
	}
}

?>