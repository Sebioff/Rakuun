<?php

/**
 * Show the public Profile of a User
 * @author dr.dent
 *
 */
class Rakuun_Intern_GUI_Panel_User_ShowProfile extends GUI_Panel {
	/* User to show the Profile of */
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name, 'Profil anzeigen');
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/showprofile.tpl');
				
		if ($this->user && $this->user->picture) {
			$this->addPanel($picture = new GUI_Panel_UploadedFile('picture', $this->user->picture, 'Profilbild von '.$this->user->nameUncolored));
			$picture->addClasses('rakuun_profilepicture');
		}

		$options = array();
		$options['conditions'][] = array('identifier IN ('.implode(', ', Rakuun_User_Specials_Database::getDatabaseIdentifiers()).')');
		$options['conditions'][] = array('user = ?', $this->user);
		$options['conditions'][] = array('active = ?', true);
		$databases = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->select($options);
		
		$databasePanels = array();
		$actualUser = Rakuun_User_Manager::getCurrentUser();
		foreach ($databases as $db) {
			if ($actualUser && $actualUser->alliance && $actualUser->alliance->canSeeDatabase($db->identifier)) {
				$this->addPanel($image = new Rakuun_Intern_GUI_Panel_Specials_Database('image_'.$db->identifier, $db->identifier, $this->user));
				$databasePanels[] = $image;
			}
		}
		$this->params->databasePanels = $databasePanels;
		
		$achievements = array();
		$eternalUser = Rakuun_DB_Containers::getUserEternalUserAssocContainer()->selectByUserFirst($this->user);
		if ($eternalUser) {
			$options = array();
			$options['order'] = 'round ASC';
			$linkedAchievements = Rakuun_DB_Containers_Persistent::getEternalUserAchievementContainer()->selectByEternalUser($eternalUser->eternalUser, $options);
			foreach ($linkedAchievements as $achievement) {
				$roundInformation = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByPK($achievement->round);
				$achievements[] = 'Runde '.$roundInformation->roundName.': '.$achievement->achievement;
			}
		}
		$this->params->achievements = $achievements;
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getUser() {
		return $this->user;
	}
}

?>