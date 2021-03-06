<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Panel to caution a User
 * It shows also all added cautions
 * Cautions can be reset by admins or by the mod who cautioned the user
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_User_Caution extends GUI_Panel {
	// user to caution
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/caution.tpl');

		$param = Router::get()->getCurrentModule()->getParam('cautionreset');
		if ($param) {
			$caution = Rakuun_DB_Containers::getCautionContainer()->selectByPK($param);
			if (self::isResetable($caution)) {
				$date = new GUI_Panel_Date('date', $caution->date);
				
				// send Information to the User
				$igm = new Rakuun_Intern_IGM('Verwarnung aufgehoben!', $caution->user, '');
				$igm->setSender($caution->admin);
				$message = 'Die Verwarnung vom '.$date->getValue().' von '.$caution->admin->name.' mit '.$caution->points.' Verwarnungspunkten wurde gelöscht!';
				$igm->setText($message);
				$igm->send();
				
				// reset the caution
				$caution->points = 0;
				Rakuun_DB_Containers::getCautionContainer()->save($caution);
			}
		}
		
		$this->addPanel($cautionuser = new Rakuun_GUI_Control_UserSelect('cautionuser', $this->user, 'User'));
		$cautionuser->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($cautionpoints = new GUI_Control_DigitBox('cautionpoints', 0, 'Verwarnpunkte', 1, 15));
		$cautionpoints->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($cautionreason = new GUI_Control_TextArea('cautionreason', '', 'Verwarngrund'));
		$cautionreason->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('caution', 'User Verwarnen'));
		
		// display all cautions
		$this->addPanel($cautionlist = new GUI_Panel_Table('cautionlist', 'Verwarnungen'));
		$cautionlist->addHeader(array('User', 'Admin', 'Punkte', 'Verwarngrund', 'Datum', 'Aktion'));
				
		foreach (Rakuun_DB_Containers::getCautionContainer()->select() as $caution) {
			$date = new GUI_Panel_Date('date', $caution->date);
			if (self::isResetable($caution)) {
				$link = new GUI_Control_Link('cautiondelete_'.$caution->getPK(), 'Verwarnung zurücknehmen', $this->getModule()->getURL(array('cautionreset' => $caution->id)));
				$link->setConfirmationMessage('Verwarnung vom '.$date->getValue().' an den User '.$caution->user->name.'wirklich zurücknehmen?');
			} else {
				$link = '';
			}
			if ($caution->user)
				$cautionlist->addLine(array($caution->user->name, $caution->admin->name, $caution->points, $caution->reason, $date->getValue(), $link));
		}
	}
	
	public function onCaution() {
		$admin = Rakuun_User_Manager::getCurrentUser();
		$cautionUser = $this->cautionuser->getUser();
		
		if ($admin->getPK() == $cautionUser->getPK()) {
			$this->addError('Sich selbst verwarnen? Stehst du auf Selbstzüchtigung? :D');
		}
		
		if ($this->hasErrors()) {
			return;
		}

		$cautionPoints = $this->cautionpoints->getValue();
		$cautionReason = $this->cautionreason->getValue();
		$caution = new DB_Record();
		$caution->user = $cautionUser;
		$caution->admin = $admin;
		$caution->points = $cautionPoints;
		$caution->reason = $cautionReason;
		$caution->date = time();
		Rakuun_DB_Containers::getCautionContainer()->save($caution);
		$this->cautionuser->resetValue();
		$this->cautionpoints->resetValue();
		$this->cautionreason->resetValue();
		
		// send information message to the cautioned user
		$igm = new Rakuun_Intern_IGM('Verwarnung!', $cautionUser, '');
		$igm->setSender($admin);
		$message = 'Du hast von '.$admin->name.' '.$cautionPoints.' Verwarnungspunkte erhalten!
			<br />Begründung:
			<br />'.$cautionReason;
		$igm->setText($message);
		$igm->send();
		
		//check if user has enough cautionpoints to be banned
		self::checkBan($cautionUser, $cautionReason, $admin);
	}
	
	/*
	 * Ban the user if he has enough cautionpoints.
	 * @param user
	 */
	private static function checkBan(Rakuun_DB_User $user, $cautionreason = '', Rakuun_DB_User $admin = null) {
		$isBanned = false;
		if (self::getCautionPoints($user) >=  15) {
			Rakuun_User_Manager::lock($user);
			$isBanned = true;
		}
		else if (self::getCautionPoints($user) >=  9) {
			Rakuun_User_Manager::lock($user, 120);
			$isBanned = true;
		}
		else if (self::getCautionPoints($user) >= 6) {
			 Rakuun_User_Manager::lock($user, 24);
			 $isBanned = true;
		}
		
		//send notificationmail to user
		if ($isBanned) {
			if ($user->mail) {
				/*
				 * Catching exceptions here because sending mails is usually not possible
				 * on DEV and that's annoying for testing.
				 */
				try {
					$mail = new Net_Mail();
					$mail->setSubject('Rakuun: dein Account wurde gesperrt!');
					$mail->addRecipients($user->nameUncolored.' <'.$user->mail.'>');
					if ($admin) {
						$mail->setSender($admin->mail, $admin->nameUncolored);
					}
					$templateEngine = new GUI_TemplateEngine();
					$templateEngine->reason = $cautionreason;
					$mail->setMessage($templateEngine->render(dirname(__FILE__).'/mail_notification.tpl'));
					$mail->send();
				}
				catch (Core_Exception $e) {
					IO_Log::get()->error($e->getTraceAsString());
				}
			}
		}
	}
	
	/**
	 * Calc the CautionPoints the user has received yet
	 * @param Rakuun_DB_User $user
	 * @return sum of the CautionPoints
	 */
	public static function getCautionPoints(Rakuun_DB_User $user = null) {
		if (!$user)
			$user = Rakuun_User_Manager::getCurrentUser();
		
		$options = array();
		$options['properties'] = 'SUM(points) AS caution_points';
		if ($cautionPoints = Rakuun_DB_Containers::getCautionContainer()->selectByUserFirst($user, $options)->cautionPoints)
			return $cautionPoints;
		else
			return 0;
	}
	
	/**
	 * Checks if the user can delete the caution
	 * @param $caution
	 * @return true, if caution is deletable, otherwise false
	 */
	private static function isResetable(DB_Record $caution = null) {
		if (!$caution) {
			return false;
		}
		
		$admin = Rakuun_User_Manager::getCurrentUser();
		return ($caution->points > 0 && $caution->user
			&& (Rakuun_TeamSecurity::get()->hasPrivilege($admin, Rakuun_TeamSecurity::PRIVILEGE_CAUTIONRESET)
			|| $admin->getPK() == $caution->admin));
	}
}

?>