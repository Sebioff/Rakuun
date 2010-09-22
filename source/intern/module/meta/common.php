<?php

class Rakuun_Intern_Module_Meta_Common extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return (isset($user->alliance) && isset($user->alliance->meta));
	}
}

?>