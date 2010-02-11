<?php

class Rakuun_GUI_Control_MapLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		if ($user === null) {
			parent::__construct($name, Rakuun_DB_User::DELETED_USER_NAME, '#', $title);
		}
		else {
			if (App::get()->getInternModule()->hasSubmodule('map'))
				$url = App::get()->getInternModule()->getSubmodule('map')->getURL(array('user' => $user->id, 'cityX' => $user->cityX, 'cityY' => $user->cityY));
			else
				$url = '#';
			parent::__construct($name, $user->cityX.':'.$user->cityY, $url, $title);
		}
	}
}

?>