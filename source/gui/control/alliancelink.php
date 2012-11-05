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

class Rakuun_GUI_Control_AllianceLink extends GUI_Control_Link {
	const DISPLAY_TAG_ONLY = 1;
	const DISPLAY_NAME_ONLY = 2;
	const DISPLAY_TAG_AND_NAME = 3;
	
	private $alliance = null;
	
	public function __construct($name, Rakuun_DB_Alliance $alliance, $title = '') {
		parent::__construct($name, '['.$alliance->tag.'] '.$alliance->name, App::get()->getInternModule()->getSubmodule('allianceview')->getURL(array('alliance' => $alliance->getPK())), $title);
		$this->alliance = $alliance;
	}
	
	public function setDisplay($display) {
		if ($display == self::DISPLAY_TAG_ONLY)
			$this->setCaption('['.$this->alliance->tag.']');
		elseif ($display == self::DISPLAY_NAME_ONLY)
			$this->setCaption($this->alliance->name);
		elseif ($display == self::DISPLAY_TAG_AND_NAME)
			$this->setCaption('['.$this->alliance->tag.'] '.$this->alliance->name);
	}
}

?>