<?php

abstract class Rakuun_Intern_Achievements_Adapter {
	private $validSinceRoundName;
	
	public function __construct($validSinceRoundName) {
		$this->validSinceRoundName = $validSinceRoundName;
	}
	
	protected function addAchievements(DB_Record $user, DB_Record $eternalUser, $roundName) {
		// endscore rank
		$options = array();
		$options['conditions'][] = array('points > ?', $user->points);
		$rank = $this->getRoundContainer('user', $roundName)->count($options) + 1;
		$this->saveAchievement($eternalUser, $roundName, 'Platz #'.$rank);
	}
	
	protected function saveAchievement(DB_Record $eternalUser, $roundName, $text) {
		$achievement = new DB_Record();
		$achievement->eternalUser = $eternalUser;
		$achievement->round = $this->getRoundInformation($roundName);
		$achievement->achievement = $text;
		Rakuun_DB_Containers_Persistent::getEternalUserAchievementContainer()->save($achievement);
	}
	
	/**
	 * @return true if the user can be authenticated, false otherwise
	 */
	public function authenticate(Rakuun_DB_User $user, $password) {
		return Rakuun_User_Manager::checkPassword($user, $password);
	}
	
	/**
	 * @return String errormessage
	 */
	public function addUserEternalUserAssoc($userName, $password, $roundName, DB_Record $eternalUser) {
		$user = $this->getRoundContainer('user', $roundName)->selectByNameFirst($userName);

		if (!$user)
			return 'Falsche Zugangsdaten';
				
		$userObject = new Rakuun_DB_User();
		$userObject->password = $user->password;
		$userObject->salt = $user->salt;
		if (!$this->authenticate($userObject, $password))
			return 'Falsche Zugangsdaten';
		
		$options = array();
		$options['conditions'][] = array('user = ?', $user->id);
		$options['conditions'][] = array('round = ?', $this->getRoundInformation($roundName));
		if (Rakuun_DB_Containers_Persistent::getEternalUserUserAssocContainer()->selectFirst($options))
			return 'Rundeninformation wurde bereits einem Spieler hinzugefügt';
		
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->beginTransaction();
		$assoc = new DB_Record();
		$assoc->eternalUser = $eternalUser;
		$assoc->user = $user->id;
		$assoc->round = $this->getRoundInformation($roundName);
		Rakuun_DB_Containers_Persistent::getEternalUserUserAssocContainer()->save($assoc);
		$this->addAchievements($user, $eternalUser, $roundName);
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->commit();
	}
	
	/**
	 * @return DB_Record
	 */
	public function getRoundInformation($roundName) {
		return Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByRoundNameFirst($roundName);
	}
	
	/**
	 * @return DB_Container
	 */
	public function getRoundContainer($containerTable, $roundName) {
		$tablePrefix = '';
		$roundInformation = $this->getRoundInformation($roundName);
		$options = array();
		$options['order'] = 'end_time DESC';
		$newestRoundInformation = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectFirst($options);
		if ($roundInformation->getPK() != $newestRoundInformation->getPK())
			$tablePrefix = Rakuun_DB_Containers_Persistent::roundNameToPrefix($roundName);
			
		$container = new DB_Container($tablePrefix.$containerTable);
		$container->setConnection(Rakuun_DB_Containers_Persistent::getPersistentConnection());
		return $container;
	}
	
	public function getValidSinceRoundName() {
		return $this->validSinceRoundName;
	}
}