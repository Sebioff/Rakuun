<?php

abstract class Rakuun_Intern_Achievements_Adapter {
	const TYPE_GENERATED = 0; // automatically awarded achievements, might be deleted and re-generated
	const TYPE_CUSTOM = 1; // custom achievements, e.g. awarded by an admin
	
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
	
	protected function saveAchievement(DB_Record $eternalUser, $roundName, $text, $type = self::TYPE_GENERATED) {
		$achievement = new DB_Record();
		$achievement->eternalUser = $eternalUser;
		$achievement->round = $this->getRoundInformation($roundName);
		$achievement->achievement = $text;
		$achievement->type = $type;
		Rakuun_DB_Containers_Persistent::getEternalUserAchievementContainer()->save($achievement);
	}
	
	/**
	 * @return true if the user can be authenticated, false otherwise
	 */
	public function authenticate(Rakuun_DB_User $user, $password) {
		return Rakuun_User_Manager::checkPassword($user, $password);
	}
	
	/**
	 * @return boolean true if the achievements of the given user have already been
	 * added to an eternal profile for the given round, false otherwise
	 */
	public function isAlreadyConnected($userName, $roundName) {
		$user = $this->getRoundContainer('user', $roundName)->selectByNameFirst($userName);
		if (!$user) {
			return false;
		}
		$options = array();
		$options['conditions'][] = array('user = ?', $user->id);
		$options['conditions'][] = array('round = ?', $this->getRoundInformation($roundName));
		return (Rakuun_DB_Containers_Persistent::getEternalUserUserAssocContainer()->selectFirst($options) !== null);
	}
	
	/**
	 * Changes the association for the given user in the given round to the given
	 * eternal user profile
	 * @return String errormessage
	 */
	public function changeUserEternalUserAssoc($userName, $password, $roundName, DB_Record $eternalUser) {
		$user = $this->getRoundContainer('user', $roundName)->selectByNameFirst($userName);

		if (!$user)
			return 'Falsche Zugangsdaten';
				
		$userObject = new Rakuun_DB_User();
		$userObject->password = $user->password;
		$userObject->salt = $user->salt;
		if (!$this->authenticate($userObject, $password))
			return 'Falsche Zugangsdaten';
		
		$roundInformation = $this->getRoundInformation($roundName);
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->beginTransaction();
		$options = array();
		$options['conditions'][] = array('user = ?', $user->id);
		$options['conditions'][] = array('round = ?', $roundInformation);
		$assoc = Rakuun_DB_Containers_Persistent::getEternalUserUserAssocContainer()->selectFirst($options);
		if (!$assoc)
			return 'Kann nicht verbinden, keine bereits bestehende Verbindung gefunden';
		$oldEternalUser = $assoc->eternalUser;
		$assoc->eternalUser = $eternalUser;
		$assoc->save();
		$options = array();
		$options['conditions'][] = array('eternal_user = ?', $oldEternalUser);
		$options['conditions'][] = array('round = ?', $roundInformation);
		foreach (Rakuun_DB_Containers_Persistent::getEternalUserAchievementContainer()->select($options) as $achievementRecord) {
			$achievementRecord->eternalUser = $eternalUser;
			$achievementRecord->save();
		}
		Rakuun_DB_Containers_Persistent::getPersistentConnection()->commit();
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
		
		if ($this->isAlreadyConnected($userName, $roundName))
			return 'Rundeninformation wurde bereits einem anderen ewigen Profil hinzugefügt';
		
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