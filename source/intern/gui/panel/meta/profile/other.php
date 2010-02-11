<?php

class Rakuun_Intern_GUI_Panel_Meta_Profile_Other extends GUI_Panel {
	public function init() {
		parent::init();
		
		$meta = Rakuun_DB_Containers::getMetasContainer()->selectByIdFirst($this->getModule()->getParam('meta'));
		$this->getModule()->setPageTitle('Meta - '.$meta->name);
		$this->setTemplate(dirname(__FILE__).'/other.tpl');
		
		$this->addPanel(new Rakuun_GUI_Panel_Box('description', $text = new GUI_Panel_Text('description', $meta->description ? $meta->description : 'Keine Beschreibung'), 'Öffentliche Metabeschreibung'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('memberbox', new Rakuun_Intern_GUI_Panel_Meta_Member('member', $meta), 'Mitglieder'));
		if ($meta->picture)
			$this->addPanel(new Rakuun_GUI_Panel_Box('picture', new GUI_Panel_UploadedFile('metapicture', $meta->picture, 'Metabild der meta '.$meta->name), 'Metabild'));
			
		$user = Rakuun_User_Manager::getCurrentUser();
		if (!$user->alliance)
			return;
			 
		if (!$user->alliance->meta && Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS))
			$this->addPanel(new Rakuun_GUI_Panel_Box('application', new Rakuun_Intern_GUI_Panel_Meta_Application('application'), 'Bei Meta bewerben'));
	}
}
?>