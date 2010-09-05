<?php

class Rakuun_Intern_GUI_Panel_Alliance_Profile_Other extends GUI_Panel {
	private $id = 0;
	
	public function __construct($name, $id, $title = '') {
		parent::__construct($name, $title);
		$this->id = $id;
	}
	
	public function init() {
		parent::init();
		
		$alliance = Rakuun_DB_Containers::getAlliancesContainer()->selectByIDFirst($this->id);
		if (!$alliance) {
			return;
		}
		$this->params->alliance = $alliance;
		
		$this->getModule()->setPageTitle('Allianz - ['.$alliance->tag.'] '.$alliance->name);
		$this->setTemplate(dirname(__FILE__).'/other.tpl');
		
		if ($alliance->picture)
			$this->addPanel(new Rakuun_GUI_Panel_Box('image', new GUI_Panel_UploadedFile('allianceimage', $alliance->picture, 'Allianzbild der Allianz '.$alliance->name), 'Allianzbild'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('memberbox', new Rakuun_Intern_GUI_Panel_Alliance_Members('members', $alliance), 'Mitglieder'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('databases', new Rakuun_Intern_GUI_Panel_Alliance_Databases('databases', $alliance), 'Datenbankteile der Meta'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('diplomacy', new Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_Overview('diplomacy_extern'), 'Diplomatische Beziehungen'));
		if (!Rakuun_User_Manager::getCurrentUser()->alliance)
			$this->addPanel(new Rakuun_GUI_Panel_Box('application', new Rakuun_Intern_GUI_Panel_Alliance_Applications_Application('application'), 'Bei Allianz bewerben'));
	}
}
?>