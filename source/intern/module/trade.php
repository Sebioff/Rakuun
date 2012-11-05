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

class Rakuun_Intern_Module_Trade extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
			
		$this->setPageTitle('Handeln');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/trade.tpl');
		
		$param = $this->getParam('user');
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
		
		$this->contentPanel->addPanel($tradeBox = new Rakuun_GUI_Panel_Box('trade', new Rakuun_Intern_GUI_Panel_Trade('trade', 'Handeln', $user)));
		$tradeBox->addClasses('rakuun_box_trade');
	}
}

?>