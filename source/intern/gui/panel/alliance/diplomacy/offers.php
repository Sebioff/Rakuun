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
 * Panel to display new relation offers
 */
class Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_Offers extends Rakuun_Intern_GUI_Panel_Alliance_Diplomacy {
	
	public function init() {
		parent::init();
		
		//Params auswerten
		// TODO use SecureSubmitButton instead of params
		if (Router::get()->getCurrentModule()->getParam('accept'))
			$this->accept(Router::get()->getCurrentModule()->getParam('accept'));
		if (Router::get()->getCurrentModule()->getParam('cancel'))
			$this->cancel(Router::get()->getCurrentModule()->getParam('cancel'));
		if (Router::get()->getCurrentModule()->getParam('deny'))
			$this->deny(Router::get()->getCurrentModule()->getParam('deny'));
		$this->getModule()->invalidate();
		$this->setTemplate(dirname(__FILE__).'/offers.tpl');
		$own = Rakuun_User_Manager::getCurrentUser()->alliance;
		$actives = Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->selectByStatus(self::STATUS_NEW, array('conditions' => array(array('alliance_active = ? OR alliance_passive = ?', $own, $own))));
		$_wars = array();
		$_naps = array();
		$_auvbs = array();
		foreach ($actives as $active) {
			$active->other = $active->allianceActive->getPK() == $own->getPK() ? $active->alliancePassive : $active->allianceActive;
			switch ($active->type) {
				case self::RELATION_AUVB:
					$_auvbs[] = $active;
				break;
				case self::RELATION_NAP:
					$_naps[] = $active;
				break;
				case self::RELATION_WAR:
					$_wars[] = $active;
				break;
			}
		}
		$this->params->auvbs = $_auvbs;
		$this->params->naps = $_naps;
		$this->params->wars = $_wars;
	}
	
	private function accept($param) {
		//accept new offers
		DB_Connection::get()->beginTransaction();
		$own = Rakuun_User_Manager::getCurrentUser()->alliance;
		$diplomacy = Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->selectByIdFirst($param, array('conditions' => array(array('alliance_passive = ?', $own), array('type IN (?, ?)', self::RELATION_AUVB, self::RELATION_NAP), array('status = ?', self::STATUS_NEW))));
		if (!$diplomacy) {
			DB_Connection::get()->rollback();
			return;
		}
		$diplomacy->status = self::STATUS_ACTIVE;
		$diplomacy->date = time();
		Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->save($diplomacy);
		$other = $diplomacy->allianceActive->getPK() == Rakuun_User_Manager::getCurrentUser()->alliance->getPK() ? $diplomacy->alliancePassive : $diplomacy->allianceActive;
		$users = Rakuun_Intern_Alliance_Security::getForAlliance($other)->getPrivilegedUsers(Rakuun_Intern_Alliance_Security::PRIVILEGE_DIPLOMACY);
		foreach ($users as $user) {
			$igm = new Rakuun_Intern_IGM('Diplomatieangebot wurde angenommen', $user);
			$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
			$igm->setText(
				'Hallo '.$user->name.',<br />'.
				Rakuun_User_Manager::getCurrentUser()->alliance->name.' hat euer Diplomatieangebot ('.($diplomacy->type == self::RELATION_AUVB ? 'AuVB' : 'NAP').') angenommen!<br />' .
				'<a href="'.App::get()->getInternModule()->getSubmodule('alliance')->getSubmodule('diplomacy')->getURL().'">Diplomatie</a>'
			);
			$igm->send();
		}
		DB_Connection::get()->commit();
	}
	
	private function cancel($param) {
		//Delete an not yet accepted / denied offer
		DB_Connection::get()->beginTransaction();
		$own = Rakuun_User_Manager::getCurrentUser()->alliance;
		$diplomacy = Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->selectByIdFirst($param, array('conditions' => array(array('alliance_active = ?', $own), array('type IN (?, ?)', self::RELATION_AUVB, self::RELATION_NAP), array('status = ?', self::STATUS_NEW))));
		if (!$diplomacy) {
			DB_Connection::get()->rollback();
			return;
		}
		Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->delete($diplomacy);
		$other = $diplomacy->allianceActive->getPK() == Rakuun_User_Manager::getCurrentUser()->alliance->getPK() ? $diplomacy->alliancePassive : $diplomacy->allianceActive;
		$users = Rakuun_Intern_Alliance_Security::getForAlliance($other)->getPrivilegedUsers(Rakuun_Intern_Alliance_Security::PRIVILEGE_DIPLOMACY);
		foreach ($users as $user) {
			$igm = new Rakuun_Intern_IGM('Diplomatieangebot wurde zurückgezogen', $user);
			$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
			$igm->setText(
				'Hallo '.$user->name.',<br />'.
				Rakuun_User_Manager::getCurrentUser()->alliance->name.' hat ein Diplomatieangebot ('.($diplomacy->type == self::RELATION_AUVB ? 'AuVB' : 'NAP').') zurückgezogen!<br />'.
				'<a href="'.App::get()->getInternModule()->getSubmodule('alliance')->getSubmodule('diplomacy')->getURL().'">Diplomatie</a>'
			);
			$igm->send();
		}
		DB_Connection::get()->commit();
	}
	
	private function deny($param) {
		//Deny an offer
		DB_Connection::get()->beginTransaction();
		$own = Rakuun_User_Manager::getCurrentUser()->alliance;
		$diplomacy = Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->selectByIdFirst($param, array('conditions' => array(array('alliance_passive = ?', $own), array('type in (?, ?)', self::RELATION_AUVB, self::RELATION_NAP), array('status = ?', self::STATUS_NEW))));
		if (!$diplomacy) {
			DB_Connection::get()->rollback();
			return;
		}
		Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->delete($diplomacy);
		$other = $diplomacy->allianceActive->getPK() == Rakuun_User_Manager::getCurrentUser()->alliance->getPK() ? $diplomacy->alliancePassive : $diplomacy->allianceActive;
		$users = Rakuun_Intern_Alliance_Security::getForAlliance($other)->getPrivilegedUsers(Rakuun_Intern_Alliance_Security::PRIVILEGE_DIPLOMACY);
		foreach ($users as $user) {
			$igm = new Rakuun_Intern_IGM('Diplomatieangebot wurde abgelehnt', $user);
			$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
			$igm->setText(
				'Hallo '.$user->name.',<br />'.
				Rakuun_User_Manager::getCurrentUser()->alliance->name.' hat ein Diplomatieangebot ('.($diplomacy->type == self::RELATION_AUVB ? 'AuVB' : 'NAP').') abgelehnt!<br />' .
				'<a href="'.App::get()->getInternModule()->getSubmodule('alliance')->getSubmodule('diplomacy')->getURL().'">Diplomatie</a>'
			);
			$igm->send();
		}
		DB_Connection::get()->commit();
	}
}

?>