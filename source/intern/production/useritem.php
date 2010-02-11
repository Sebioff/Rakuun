<?php

/**
 * Base class for all items a user can build
 */
abstract class Rakuun_Intern_Production_UserItem extends Rakuun_Intern_Production_Base {
	/**
	 * @return Rakuun_DB_User
	 */
	public function getUser() {
		return $this->getOwner();
	}
}

?>