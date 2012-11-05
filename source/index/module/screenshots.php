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

class Rakuun_Index_Module_Screenshots extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Screenshots');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/screenshots.tpl');
		$this->setMetaTag('description', 'Screenshots von Rakuun, dem kostenlosen SciFi-Browsergame');
		$this->setMetaTag('keywords', 'weltraum, screenshots, bilder, spiel');
		$this->addCssRouteReference('css', 'panel/lightbox/lightbox.css');
		$this->addJsRouteReference('js', 'panel/lightbox/jquery.lightbox.js');
		$this->addJsAfterContent('
			$(".lightbox").lightbox({
			    fitToScreen: true,
			    imageClickClose: false,
			    fileLoadingImage: "'.Router::get()->getStaticRoute('images', 'lightbox/loading.gif').'",
				fileBottomNavCloseImage: "'.Router::get()->getStaticRoute('images', 'lightbox/closelabel.gif').'"
		    });
		');
	}
}

?>