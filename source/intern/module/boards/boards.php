<?php

class Rakuun_Intern_Module_Boards extends Rakuun_Intern_Module_Boards_Navigation {
	public function __construct($name) {
		parent::__construct($name);
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($user) {
			$this->addSubmodule(new Rakuun_Intern_Module_Boards_Global('global'));
			if ($user->alliance) {
				$this->addSubmodule(new Rakuun_Intern_Module_Boards_Alliance('alliance'));
				if ($user->alliance->meta)
					$this->addSubmodule(new Rakuun_Intern_Module_Boards_Meta('meta'));
			}
			if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_BACKENDACCESS))
				$this->addSubmodule(new Rakuun_Intern_Module_Boards_Admin('admin'));
		}
	}
	
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/boards.tpl');
		$this->setPageTitle('Ãœbersicht');
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Board_Overview('overview'));
	}
}
?>