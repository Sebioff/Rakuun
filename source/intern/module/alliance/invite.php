<?php

class Rakuun_Intern_Module_Alliance_Invite extends Rakuun_Intern_Module_Alliance_Navigation implements Scriptlet_Privileged {
	const MAX_INVITATIONS_PER_DAY = 3;
	
	public function init() {
		parent::init();

		$alliance = $this->getUser()->alliance;
		$this->setPageTitle('Einladung verschicken - ['.$alliance->tag.'] '.$alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/invite.tpl');
		
		$this->contentPanel->addPanel(new GUI_Panel_Text('counter', 'Heute können noch '.(self::MAX_INVITATIONS_PER_DAY - $alliance->invitations).' Einladungen verschickt werden.'));
		if ($alliance->invitations < self::MAX_INVITATIONS_PER_DAY) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('invite', new Rakuun_Intern_GUI_Panel_Alliance_Invite('invite'), 'Allianzlose Spieler einladen'));
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_APPLICATIONS);
	}
}
?>