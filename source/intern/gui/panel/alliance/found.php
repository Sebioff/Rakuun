<?php

/**
 * Panel to found an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Found extends GUI_Panel {
	private $ironCosts = 0;
	private $berylliumCosts = 0;
	
	public function __construct($name, $ironCosts, $berylliumCosts) {
		parent::__construct($name);
		$this->ironCosts = $ironCosts;
		$this->berylliumCosts = $berylliumCosts;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/found.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Allianzname'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new GUI_Validator_RangeLength(2, 25));
		$name->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($tag = new GUI_Control_TextBox('tag', null, 'Allianztag'));
		$tag->addValidator(new GUI_Validator_Mandatory());
		$tag->addValidator(new GUI_Validator_RangeLength(1, 10));
		$tag->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Gründen'));
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$ressources = $user->ressources;
		if ($ressources->iron < $this->getIronCosts() || $ressources->beryllium < $this->getBerylliumCosts()) {
			$this->addError('Nicht genügend Rohstoffe vorhanden');
		}
		
		$allianceExists = Rakuun_DB_Containers::getAlliancesContainer()->selectFirst(array('conditions' => array(array('name LIKE ? OR tag LIKE ?', $this->name, $this->tag))));
		if ($allianceExists) {
			$this->addError('Eine Allianz mit diesem Namen oder diesem Tag existiert bereits');
		}
		
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		// create alliance
		$alliance = new Rakuun_DB_Alliance();
		$alliance->name = $this->name;
		$alliance->tag = $this->tag;
		Rakuun_DB_Containers::getAlliancesContainer()->save($alliance);
		// take ressources for founding
		$ressources->lower($this->getIronCosts(), $this->getBerylliumCosts());
		// add founder to alliance
		$user->alliance = $alliance;
		Rakuun_User_Manager::update($user);
		// add leader rank to alliance
		$leaderRank = new DB_Record();
		$leaderRank->alliance = $alliance;
		$leaderRank->name = 'Leiter';
		$leaderRank->groupIdentifier = Rakuun_Intern_Alliance_Security::GROUP_LEADERS;
		Rakuun_Intern_Alliance_Security::get()->getContainerGroups()->save($leaderRank);
		Rakuun_Intern_Alliance_Security::get()->addToGroup($user, $leaderRank);
		// set applications to other alliances to STATUS_JOINED_OTHER
		$applications = Rakuun_DB_Containers::getAlliancesApplicationsContainer()->selectByUser($user);
		foreach ($applications as $application) {
			$application->status = Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_JOINED_OTHER;
			$application->date = time();
			Rakuun_DB_Containers::getAlliancesApplicationsContainer()->save($application);
		}
		$allianceBuildings = new DB_Record();
		$allianceBuildings->alliance = $alliance;
		Rakuun_DB_Containers::getAlliancesBuildingsContainer()->save($allianceBuildings);
		$alliancehistory = new Rakuun_Intern_Alliance_History($user, $alliance->name, Rakuun_Intern_Alliance_History::TYPE_FOUND);
		$alliancehistory->save();
		DB_Connection::get()->commit();
		$this->getModule()->redirect(App::get()->getInternModule()->getSubmodule('alliance')->getURL());
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getIronCosts() {
		return $this->ironCosts;
	}
	
	public function getBerylliumCosts() {
		return $this->berylliumCosts;
	}
}

?>