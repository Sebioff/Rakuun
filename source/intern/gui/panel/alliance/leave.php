<?php

/**
 * Panel which displays a link to leave an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Leave extends GUI_Panel {
	/** The time after which the decision to leave the alliance (voluntarily or
	 * forced) becomes valid */
	const LEAVE_TIMEOUT = 86400; // 1 day
	
	public function __construct($name, $title = '') {
		parent::__construct($name, $title);
		
		$this->addPanel($leave = new GUI_Control_SecureSubmitButton('leave', 'Verlassen'));
		$leave->setConfirmationMessage('Der Austritt wird erst nach '.Rakuun_Date::formatCountDown(self::LEAVE_TIMEOUT).' gültig.\nWillst du die Allianz wirklich verlassen?');
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
		if ($user->allianceLeaveTime > 0) {
			$this->addError('Dieser Spieler verlässt bereits die Allianz.');
		}
		if ($this->hasErrors())
			return;
		
		//save alliancehistory
		$alliancehistory = new Rakuun_Intern_Alliance_History($user, $user->alliance->name, Rakuun_Intern_Alliance_History::TYPE_LEAVE);
		$alliancehistory->save();
		
		// start alliance leave countdown
		$user->allianceLeaveTime = time();
		Rakuun_User_Manager::update($user);
		DB_Connection::get()->commit();
		
		$this->getModule()->redirect(App::get()->getInternModule()->getURL());
	}
}

?>