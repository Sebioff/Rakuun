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
 * Show the public Profile of a User
 * @author dr.dent
 */
class Rakuun_Intern_Module_ShowProfile extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Profil anzeigen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/showprofile.tpl');
		
		$param = $this->getParam('user');
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
		if ($user) {
			$this->contentPanel->addPanel($profileBox = new Rakuun_GUI_Panel_Box('showprofile', new Rakuun_Intern_GUI_Panel_User_ShowProfile('showprofile', $user), 'Profil von '.$user->name));
			$profileBox->addClasses('rakuun_user_profile_box');
			$this->contentPanel->addPanel($allianceHistory = new Rakuun_GUI_Panel_Box('alliancehistory', new Rakuun_Intern_GUI_Panel_User_AllianceHistory('alliancehistory', $user), 'Allianzhistory'));
			if ($user->getPK() != Rakuun_User_Manager::getCurrentUser()->getPK()) {
				$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('armybox', new Rakuun_Intern_GUI_Panel_Reports_Display_Army('army', $user), 'Einheitenübersicht'));
				$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('buildingsbox', new Rakuun_Intern_GUI_Panel_Reports_Display_Buildings('buildings', $user), 'Gebäudeübersicht'));
				$this->contentPanel->addPanel($detailBox = new Rakuun_GUI_Panel_Box('detailsbox', null, 'Details'));
				$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('reportsbox', new Rakuun_Intern_GUI_Panel_Reports_ForUser('reports', $user, $detailBox), 'Berichteübersicht'));
			}
		}
	}
}

?>