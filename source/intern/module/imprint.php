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
 * A Module for displaying the imprint and donations introductions
 * @author Sebioff
 */
class Rakuun_Intern_Module_Imprint extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
			
		$this->setPageTitle('Spenden/Impressum');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/imprint.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('donation', new Rakuun_Intern_GUI_Panel_Imprint_Donation('donation'), 'Spenden'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('imprint', new Rakuun_Intern_GUI_Panel_Imprint('imprint'), 'Impressum'));
	}
}

?>