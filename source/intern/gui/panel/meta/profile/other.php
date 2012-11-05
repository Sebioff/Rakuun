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

class Rakuun_Intern_GUI_Panel_Meta_Profile_Other extends GUI_Panel {
	public function init() {
		parent::init();
		
		$meta = Rakuun_DB_Containers::getMetasContainer()->selectByIdFirst($this->getModule()->getParam('meta'));
		if ($meta) {
			$this->getModule()->setPageTitle('Meta - '.$meta->name);
			$this->setTemplate(dirname(__FILE__).'/other.tpl');
			
			$text = Rakuun_Text::formatPlayerText($meta->description, false);
			$spyLink = new GUI_Control_Link('spylink', 'Spionageberichte zu dieser Meta', Rakuun_Intern_Modules::get()->getSubmodule('reports')->getUrl(array('show' => Rakuun_Intern_Module_Reports::SHOW_FOR_META, 'id' => $meta->getPK())));
			$text .= '<br /><br />'.$spyLink->render();
			$this->addPanel(new Rakuun_GUI_Panel_Box('description', new GUI_Panel_Text('description', $text), 'Öffentliche Metabeschreibung'));
			$this->addPanel(new Rakuun_GUI_Panel_Box('memberbox', new Rakuun_Intern_GUI_Panel_Meta_Member('member', $meta), 'Mitglieder'));
			if ($meta->picture) {
				$this->addPanel(new Rakuun_GUI_Panel_Box('picturebox', $picture = new GUI_Panel_UploadedFile('metapicture', $meta->picture, 'Metabild der meta '.$meta->name), 'Metabild'));
				$picture->addClasses('rakuun_profilepicture');
			}
			else
				$this->addPanel(new Rakuun_GUI_Panel_Box('picturebox', new GUI_Panel_Text('dummy', 'Kein Bild'), 'Metabild'));
			$user = Rakuun_User_Manager::getCurrentUser();
			if (!$user->alliance)
				return;
				 
			if (!$user->alliance->meta && Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS))
				$this->addPanel(new Rakuun_GUI_Panel_Box('application', new Rakuun_Intern_GUI_Panel_Meta_Application('application'), 'Bei Meta bewerben'));
		}
	}
}
?>