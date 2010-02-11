<?php

/**
 * Create a Link to Trade with a User
 * make sure, that the User has the Abilities to Trade with using this Link
 * @author dr.dent
 */
class Rakuun_GUI_Control_TradeLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		if ($user === null) {
			parent::__construct($name, Rakuun_DB_User::DELETED_USER_NAME, '#', $title);
		}
		else {
			if (App::get()->getInternModule()->hasSubmodule('trade'))
				$url = App::get()->getInternModule()->getSubmodule('trade')->getURL(array('user' => $user->id));
			else
				$url = '#';
			parent::__construct($name, 'mit '.$user->name.' Handeln', $url, $title);
		}
	}
}

?>