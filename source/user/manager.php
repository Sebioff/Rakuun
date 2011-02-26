<?php

abstract class Rakuun_User_Manager {
	/**
	 * Returns the currently logged-in user.
	 * @return Rakuun_DB_User
	 */
	public static function getCurrentUser() {
		if (isset($_SESSION['user']))
			return Rakuun_DB_Containers::getUserContainer()->selectByPK($_SESSION['user']);
		else
			return null;
	}
	
	public static function isSitting() {
		return (isset($_SESSION['isSitting']) && $_SESSION['isSitting'] === true);
	}
	
	public static function login($username, $password) {
		$user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($username);
		
		if (!self::checkPassword($user, $password) && !Rakuun_User_Manager::isMasterUser())
			return 'Falsches Passwort oder Benutzername';

		if (!Rakuun_GameSecurity::get()->hasPrivilege($user, Rakuun_GameSecurity::PRIVILEGE_LOGIN) && !Rakuun_User_Manager::isMasterUser())
			return 'Login dieses Spielers ist gesperrt';
			
		if ($user->isYimtay() && !Rakuun_User_Manager::isMasterUser())
			return 'Dieser Account ist inaktiv und wird demnächst gelöscht';
		
		$user->lastLogin = time();
		$user->lastActivity = time();
		$user->isOnline = time();
		$user->lastBotVerification = time();
		$user->ip = $_SERVER['REMOTE_ADDR'];
		$user->save();
		
		$_SESSION['user'] = $user->getPK();
		$_SESSION['isSitting'] = false;
	}
	
	public static function update(Rakuun_DB_User $user) {
		Rakuun_DB_Containers::getUserContainer()->save($user);
	}
	
	// TODO add locking reason
	/**
	 * lock a user
	 * @param Rakuun_DB_User $user
	 * @param $time time in hours to lock the user in time. 0 for permanent ban
	 */
	public static function lock(Rakuun_DB_User $user, $time = 0) {
		$user->isOnline = 0;
		self::update($user);
		
		if (!Rakuun_GameSecurity::get()->isInGroup($user, Rakuun_GameSecurity::GROUP_LOCKED)) {
			Rakuun_GameSecurity::get()->addToGroup($user, Rakuun_GameSecurity::get()->getGroup(Rakuun_GameSecurity::GROUP_LOCKED));
			
			if ($time != 0) {
				$ban = new DB_Record();
				$ban->user = $user;
				$ban->time = time() + $time * 60 * 60; //time + hours
				Rakuun_DB_Containers::getUserBannedContainer()->save($ban);
			}
		}
	}
	
	public static function unlock(Rakuun_DB_User $user) {
		Rakuun_GameSecurity::get()->removeFromGroup($user, Rakuun_GameSecurity::get()->getGroup(Rakuun_GameSecurity::GROUP_LOCKED));
		
		$options = array();
		$options['conditions'][] = array('user = ?', $user);
		$timeban = Rakuun_DB_Containers::getUserBannedContainer()->selectFirst($options);
		if ($timeban)
			Rakuun_DB_Containers::getUserBannedContainer()->delete($timeban);
	}
	
	public static function logout() {
		$user = self::getCurrentUser();
		if ($user) {
			$user->isOnline = 0;
			self::update($user);
			Rakuun_Intern_Log_UserActivity::log($user, Rakuun_Intern_Log::ACTION_ACTIVITY_LOGOUT);
			unset($_SESSION['user']);
		}
	}
	
	public static function checkPassword(Rakuun_DB_User $user = null, $password = '') {
		return ($user && $user->password == self::cryptPassword($password, $user->salt));
	}
	
	public static function cryptPassword($original, $salt = '') {
		return md5($original.PROJECT_NAME.$salt);
	}
	
	public static function delete(Rakuun_DB_User $user, $reason) {
		Rakuun_DB_Containers::getUserContainer()->delete($user);
		$deletedUser = Rakuun_DB_Containers::getUserDeletedContainer()->selectByIdFirst($user->getPK());
		$deletedUser->message = $reason;
		Rakuun_DB_Containers::getUserDeletedContainer()->save($deletedUser);
	}
	
	public static function isMasterUser() {
		return (isset($_COOKIE['mk_cookie']) && md5($_COOKIE['mk_cookie']) == MASTERKEY);
	}
}

?>