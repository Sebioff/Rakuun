<?php

/**
 * Displays a link to delete a user as admin control.
 * @author dr.dent
 */
class Rakuun_GUI_Control_UserDeleteLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		if ($user === null) {
			parent::__construct($name, Rakuun_DB_User::DELETED_USER_NAME, '#', $title);
		}
		else {
			$url = App::get()->getInternModule()->getSubmodule('admin')->getURL(array('delete' => $user->id));
			parent::__construct($name, 'User '.$user->name.' löschen', $url, $title);
		}
	}
}

?>