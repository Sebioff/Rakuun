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
 * Panel with links to kick users from your alliance
 */
class Rakuun_Intern_GUI_Panel_Alliance_Kick extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/kick.tpl');
		$this->params->members = Rakuun_User_Manager::getCurrentUser()->alliance->members;
		foreach ($this->params->members as $member) {
			$this->addPanel($blanko = new GUI_Panel('blanko'.$member->getPK()));
			$blanko->addPanel($kickbutton = new GUI_Control_SecureSubmitButton('kick', 'kicken'));
			$kickbutton->setTitle($member->nameUncolored);
			$kickbutton->setConfirmationMessage('Der Austritt wird erst nach '.Rakuun_Date::formatCountDown(Rakuun_Intern_GUI_Panel_Alliance_Leave::LEAVE_TIMEOUT).' gültig.\nWillst du '.$member->nameUncolored.' wirklich kicken?');
			$blanko->addPanel(new GUI_Control_HiddenBox('id', $member->getPK()));
		}
	}
	
	public function onKick() {
		if ($this->hasErrors())
			return;
			
		foreach ($this->params->members as $member) {
			if ($this->{'blanko'.$member->getPK()}->hasBeenSubmitted()) {
				// check requirements to kick the user
				DB_Connection::get()->beginTransaction();
				$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->{'blanko'.$member->getPK()}->id->getValue(), array('conditions' => array(array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance))));
				if (!$user) {
					$this->addError('Dieser User gehört nicht zu deiner Allianz!');
					DB_Connection::get()->rollback();
					return;
				}
				if ($user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK()) {
					$this->addError('Sich selbst kicken? Persönlichkeitsstörung? :D');
					DB_Connection::get()->rollback();
					return;
				}
				if (Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)) {
					$this->addError('Dieser User ist in der Leiter-Gruppe und kann daher nicht gekickt werden!');
					DB_Connection::get()->rollback();
					return;
				}
				if ($user->allianceLeaveTime > 0) {
					$this->addError('Dieser Spieler verlässt bereits die Allianz.');
					DB_Connection::get()->rollback();
					return;
				}
				if ($user->getDatabaseCount() > 0) {
					$this->addError('Dieser User bewacht ein Datenbankteil und kann die Allianz daher nicht verlassen.');
					DB_Connection::get()->rollback();
					return;
				}
				// send information message to the user
				$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
				$allianceLink = new Rakuun_GUI_Control_AllianceLink('alliancelink', $alliance);
				$aktUserLink = new Rakuun_GUI_Control_UserLink('userlink', Rakuun_User_Manager::getCurrentUser());
				$allianceModuleLink = new GUI_Control_Link('allianceslink', 'Allianzen', App::get()->getInternModule()->getSubmodule('alliance')->getURL());
				$igm = new Rakuun_Intern_IGM('Kick aus Allianz', $user);
				$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
				$igm->setText(
					'Du wurdest von '.$aktUserLink->render().' aus der Allianz '.$allianceLink->render().' gekickt!<br />'.
					'Der Austritt wird nach '.Rakuun_Date::formatCountDown(Rakuun_Intern_GUI_Panel_Alliance_Leave::LEAVE_TIMEOUT).' gültig.<br />'.
					$allianceModuleLink->render()
				);
				$igm->send();
				// start alliance leave countdown
				$user->allianceLeaveTime = time();
				Rakuun_User_Manager::update($user);
				$this->getModule()->invalidate();
				//save alliancehistory
				$alliancehistory = new Rakuun_Intern_Alliance_History($user, $alliance->name, Rakuun_Intern_Alliance_History::TYPE_KICK);
				$alliancehistory->save();
				DB_Connection::get()->commit();
			}
		}
	}
}

?>