<?php

/**
 * Create a Link to send am Message to a User
 * make sure, that the User has the Abilities to Trade with using this Link
 * @author dr.dent
 */
class Rakuun_GUI_Control_SendMessageLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		if ($user === null) {
			parent::__construct($name, Rakuun_DB_User::DELETED_USER_NAME, '#', $title);
		}
		else {
			if (App::get()->getInternModule()->hasSubmodule('messages'))
				$url = App::get()->getInternModule()->getSubmodule('messages')->getURL(array('user' => $user->id));
			else
				$url = '#';
			parent::__construct($name, $user->name.' eine Nachricht schicken', $url, $title);
		}
	}
}

?>