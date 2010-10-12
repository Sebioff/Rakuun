<?php

class Rakuun_Intern_GUI_Panel_Board_Overview extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/overview.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addPanel(new Rakuun_GUI_Panel_Box('globalbox', new Rakuun_Intern_GUI_Panel_Board_Overview_Global('overview'), 'Neues aus dem Allgemeinen Forum'));
		if ($user->alliance) {
			$this->addPanel(new Rakuun_GUI_Panel_Box('alliancebox', new Rakuun_Intern_GUI_Panel_Board_Overview_Alliance('overview'), 'Neues aus dem Allianzforum'));
			if ($user->alliance->meta) {
				$this->addPanel(new Rakuun_GUI_Panel_Box('metabox', new Rakuun_Intern_GUI_Panel_Board_Overview_Meta('overview'), 'Neues aus dem Metaforum'));
			}
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_BACKENDACCESS)) {
			$this->addPanel(new Rakuun_GUI_Panel_Box('adminbox', new Rakuun_Intern_GUI_Panel_Board_Overview_Admin('overview'), 'Neues aus dem Admin Forum')); 
		}
	}
}
?>