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

class Rakuun_Intern_Module_Meta_Edit extends Rakuun_Intern_Module_Meta_Common {
	public function init() {
		parent::init();

		$this->setPageTitle('Bearbeiten - '.$this->getUser()->alliance->meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/edit.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('edit', new Rakuun_Intern_GUI_Panel_Meta_Edit('edit'), 'Meta Details bearbeiten'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('kick', new Rakuun_Intern_GUI_Panel_Meta_Kick('kick'), 'Allianz kicken'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('mail', new Rakuun_Intern_GUI_Panel_Meta_Mail('mail', $this->getUser()->alliance->meta), 'Metarundmail schreiben'));
	}
}

?>