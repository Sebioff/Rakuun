<?php

class Rakuun_Intern_Module_Alliance_Edit extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$this->setPageTitle('Bearbeiten - ['.$this->getUser()->alliance->tag.'] '.$this->getUser()->alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/edit.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_INFORMATION))
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('edit', new Rakuun_Intern_GUI_Panel_Alliance_Edit('edit'), 'Details bearbeiten'));
		if (Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS))
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('delete', new Rakuun_Intern_GUI_Panel_Alliance_Delete('delete_alliance'), 'Allianz löschen'));
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_KICKING))
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('kick', new Rakuun_Intern_GUI_Panel_Alliance_Kick('kick'), 'Member kicken'));
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_NEWSLETTER))
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('mail', new Rakuun_Intern_GUI_Panel_Alliance_Mail('mail', $this->getUser()->alliance), 'Allianzrundmail schreiben'));
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_APPLICATIONS))
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('invite', new Rakuun_Intern_GUI_Panel_Alliance_Invite('invite'), 'Allianzlose Spieler einladen'));
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_RANKS)) {
			$this->contentPanel->addPanel($rankSelect = new Rakuun_GUI_Panel_Box('ranks', new Rakuun_Intern_GUI_Panel_Alliance_Ranks_View('ranks'), 'Ränge'));
			$rankSelect->addClasses('rakuun_box_alliance_rankselect');
			$rank = Rakuun_Intern_Alliance_Security::get()->getContainerGroups()->selectByPK($this->getParam('rank'));
			$this->contentPanel->addPanel($rankEdit = new Rakuun_GUI_Panel_Box('new_rank', new Rakuun_Intern_GUI_Panel_Alliance_Ranks_Edit('new_rank', $rank), 'Neuer Rang'));
			$rankEdit->addClasses('rakuun_box_alliance_rankedit');
		}
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_ACTIVITY))
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('activity', new Rakuun_Intern_GUI_Panel_Alliance_Activity('activityoverview'), 'Letzte Aktivitäten'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_INFORMATION)
			|| Rakuun_Intern_Alliance_Security::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::GROUP_LEADERS)
			|| Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_KICKING)
			|| Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_NEWSLETTER)
			|| Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_APPLICATIONS)
			|| Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_RANKS));
	}
}

?>