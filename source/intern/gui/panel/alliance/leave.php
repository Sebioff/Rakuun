<?php

/**
 * Panel which displays a link to leave an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Leave extends GUI_Panel {
	public function __construct($name, $title = '') {
		parent::__construct($name, $title);
		
		$this->addPanel($leave = new GUI_Control_SecureSubmitButton('leave', 'Verlassen'));
		$leave->setConfirmationMessage('Willst du die Allianz wirklich verlassen?');
	}

	public function onLeave() {
		DB_Connection::get()->beginTransaction();
		$user = Rakuun_User_Manager::getCurrentUser();
		$leaders = Rakuun_Intern_Alliance_Security::get()->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
		if (count($leaders) == 1 && Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)) {
			$this->addError('Du bist der einzige in der Leiter-Gruppe deiner Allianz und kannst sie daher nicht verlassen.');
		}
		if ($user->getDatabaseCount() > 0) {
			$this->addError('Du bewachst ein Datenbankteil und kannst die Allianz daher nicht verlassen.');
		}
		if ($this->hasErrors())
			return;
		
		$user->alliance = null;
		Rakuun_User_Manager::update($user);
		DB_Connection::get()->commit();
		Router::get()->getCurrentModule()->invalidate();
	}
}

?>