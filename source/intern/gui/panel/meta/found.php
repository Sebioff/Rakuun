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

class Rakuun_Intern_GUI_Panel_Meta_Found extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/found.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name'));
		$name->setTitle('Name');
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'gründen'));
	}
	
	public function onSubmit() {
		DB_Connection::get()->beginTransaction();
		$metaExists = Rakuun_DB_Containers::getMetasContainer()->selectFirst(array('conditions' => array(array('name LIKE ?', $this->name))));
		if ($metaExists) {
			$this->addError('Eine Meta mit diesem Namen existiert bereits');
		}
		
		if ($this->hasErrors())
			return;
		
		$meta = new Rakuun_DB_Meta();
		$meta->name = $this->name;
		Rakuun_DB_Containers::getMetasContainer()->save($meta);
		$metaBuildings = new DB_Record();
		$metaBuildings->meta = $meta;
		Rakuun_DB_Containers::getMetasBuildingsContainer()->save($metaBuildings);
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->alliance->meta = $meta;
		Rakuun_User_Manager::update($user);
		Rakuun_DB_Containers::getAlliancesContainer()->save($user->alliance);
		DB_Connection::get()->commit();
		Scriptlet::redirect(App::get()->getInternModule()->getSubmodule('meta')->getURL());
	}
}

?>