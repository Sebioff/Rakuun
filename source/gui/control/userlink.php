<?php

/**
 * Displays a link to user's profile.
 * @param $userID only required if $user might be null
 */
class Rakuun_GUI_Control_UserLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_User $user = null, $userID = 0, $title = '') {
		if ($user === null) {
			if ($userID && $user = Rakuun_DB_Containers::getUserDeletedContainer()->selectByPK($userID))
				parent::__construct($name, $user->name, '#', $title);
			else
				parent::__construct($name, Rakuun_DB_User::DELETED_USER_NAME, '#', $title);
		}
		else {
			$url = App::get()->getInternModule()->getSubmodule('showprofile')->getURL(array('user' => $user->id));
			parent::__construct($name, $user->name, $url, $title);
		}
	}
}

?>