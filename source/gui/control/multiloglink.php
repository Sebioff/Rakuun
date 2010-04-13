<?php

/**
 * Create a link to show the log of a user
 * @author dr.dent
 */
class Rakuun_GUI_Control_MultiLogLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		if ($user === null) {
			parent::__construct($name, Rakuun_DB_User::DELETED_USER_NAME, '#', $title);
		}
		else {
			if (App::get()->getInternModule()->hasSubmodule('multihunting'))
				$url = App::get()->getInternModule()->getSubmodule('multihunting')->getURL(array('user' => $user->id));
			else
				$url = '#';
			parent::__construct($name, 'Multilog von '.$user->name.' anschauen', $url, $title);
		}
	}
}

?>