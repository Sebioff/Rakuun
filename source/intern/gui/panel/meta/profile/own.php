<?php

class Rakuun_Intern_GUI_Panel_Meta_Profile_Own extends GUI_Panel {
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$meta = $user->alliance->meta;
		$this->setTemplate(dirname(__FILE__).'/own.tpl');
		$this->getModule()->setPageTitle('Meta - '.$meta->name);
		
		$this->addPanel(new Rakuun_GUI_Panel_Box('description', new GUI_Panel_Text('description', $meta->description ? $meta->description : 'Keine Beschreibung'), 'Öffentliche Metabeschreibung'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('intern', $intern = new GUI_Panel_Text('intern', $meta->intern ? $meta->intern : 'Keine Beschreibung'), 'Interne Informationen'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('membersbox', new Rakuun_Intern_GUI_Panel_Meta_Member('member', $meta), 'Mitglieder'));
		if (Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)) {
			$this->addPanel(new Rakuun_GUI_Panel_Box('account', new Rakuun_Intern_GUI_Panel_Meta_Account('account'), 'Metakonto'));
			$this->addPanel(new Rakuun_GUI_Panel_Box('deposit', new Rakuun_Intern_GUI_Panel_Meta_Account_Deposit('deposit'), 'Auf Metakonto einzahlen'));
			$this->addPanel(new Rakuun_GUI_Panel_Box('leave', new Rakuun_Intern_GUI_Panel_Meta_Leave('leave'), 'Meta verlassen'));
			$this->addPanel(new Rakuun_GUI_Panel_Box('movements', new Rakuun_Intern_GUI_Panel_Meta_Account_AllianceAccounts('metaaccounts'), 'Kontobewegungen'));
		}
		if ($meta->picture)
			$this->addPanel(new Rakuun_GUI_Panel_Box('picture', new GUI_Panel_UploadedFile('metaepicture', $meta->picture, 'Metabild der Meta '.$meta->name), 'Metabild'));
	}
}
?>