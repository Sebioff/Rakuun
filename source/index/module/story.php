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

class Rakuun_Index_Module_Story extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Story');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/story.tpl');
		$this->setMetaTag('description', 'Steige in die Welt des kostenlosen SciFi-Browsergames Rakuun ein und kämpfe um die Herrschaft über den Planeten und den Bau eines gigantischen Raumschiffes!');
		$this->setMetaTag('keywords', 'browsergame, scifi, story');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('story', new Rakuun_Index_Panel_Story('content'), 'Story'));
	}
}

?>