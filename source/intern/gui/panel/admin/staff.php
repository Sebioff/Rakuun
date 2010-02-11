<?php

/**
 * Panel to add VIPs
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_Staff extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/staff.tpl');
		
		$this->addPanel($user = new Rakuun_GUI_Control_UserSelect('user', null, 'User'));
		$user->addValidator(new GUI_Validator_Mandatory());
		
		$this->addPanel($groups = new GUI_Control_CheckBoxList('groups', 'Gruppen'));
		foreach (Rakuun_GameSecurity::get()->getVIPGroups() as $group) {
			$groups->addItem($group->name, $group->groupIdentifier);
		}
		
		$this->addPanel(new GUI_Control_SubmitButton('register', 'User als VIP eintragen'));
	}
	
	public function onRegister() {
		if ($this->hasErrors())
			return;
		
		$user = $this->user->getUser();
		$admin = Rakuun_User_Manager::getCurrentUser();
		$msgGroups = array();
		DB_Connection::get()->beginTransaction();
		Rakuun_GameSecurity::get()->removeFromAllGroups($user);
		foreach ($this->groups->getSelectedItems() as $item) {
			$group = Rakuun_GameSecurity::get()->getGroup($item->getValue());
			Rakuun_GameSecurity::get()->addToGroup($user, $group);
			$msgGroups[$group->groupIdentifier] = $group->name;
		}
		DB_Connection::get()->commit();
		
		// send information message to the user
		$igm = new Rakuun_Intern_IGM('Eintragung!', $user, '');
		$igm->setSender($admin);
		$message = 'Du bist von '.$admin->name.' in folgende Gruppen eingetragen worden:<br/>'.implode('<br/>', $msgGroups);
		if (isset($msgGroups[Rakuun_GameSecurity::GROUP_DONORS]) || isset($msgGroups[Rakuun_GameSecurity::GROUP_SPONSORS])) {
			$message .= '<br/>Vielen Dank für deine Spende! Du hast neue Funktionen erhalten.';
			$message .= '<br/><a href="'.App::get()->getInternModule()->getSubmodule('profile')->getURL().'">Profil</a>';
		}
		$igm->setText($message);
		$igm->send();
	}
}

?>