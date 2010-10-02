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
		
		$this->getModule()->setPageTitle('Allianz - ['.$alliance->tag.'] '.$alliance->name);
		$this->setTemplate(dirname(__FILE__).'/other.tpl');
		
		$this->addPanel(new Rakuun_GUI_Panel_Box('externbox', new GUI_Panel_Text('extern', Text::format($alliance->description)), '['.$alliance->tag.'] '.$alliance->name));
		if ($alliance->picture)
			$this->addPanel($picture = new Rakuun_GUI_Panel_Box('picture', new GUI_Panel_UploadedFile('allianceimage', $alliance->picture, 'Allianzbild der Allianz '.$alliance->name), 'Allianzbild'));
		$this->addPanel($memberBox = new Rakuun_GUI_Panel_Box('memberbox', new Rakuun_Intern_GUI_Panel_Alliance_Members('members', $alliance), 'Mitglieder'));
		$memberBox->addClasses('rakuun_box_alliance_members');
		$this->addPanel($databases = new Rakuun_GUI_Panel_Box('databases', new Rakuun_Intern_GUI_Panel_Alliance_Databases('databases', $alliance), 'Datenbankteile der Allianz'));
		$databases->addClasses('rakuun_box_alliance_databases');
		$this->addPanel($diplomacy = new Rakuun_GUI_Panel_Box('diplomacy', new Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_Overview('diplomacy_extern'), 'Diplomatische Beziehungen'));
		$diplomacy->addClasses('rakuun_box_alliance_diplomacy');
		if ($alliance->meta) {
			$this->addPanel($meta = new Rakuun_GUI_Panel_Box('metabox', new Rakuun_Intern_GUI_Panel_Meta_List('alliances', $alliance->meta), 'Meta '.$alliance->meta->name));
			$meta->addClasses('rakuun_box_alliance_meta');
		}
		if (!Rakuun_User_Manager::getCurrentUser()->alliance && Rakuun_GameSecurity::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_GameSecurity::PRIVILEGE_JOIN_ALLIANCES)) {
			$this->addPanel($application = new Rakuun_GUI_Panel_Box('application', new Rakuun_Intern_GUI_Panel_Alliance_Applications_Application('application'), 'Bei Allianz bewerben'));
			$application->addClasses('rakuun_box_alliance_application');
		}
	}
}
?>