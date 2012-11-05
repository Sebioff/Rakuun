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

abstract class Rakuun_GUI_Skin {
	private $name = '';
	private $nameID = '';
	private $cssRouteReferences = array();

	public function __construct($name, $nameID) {
		$this->name = $name;
		$this->nameID = $nameID;
		$this->addCssRouteReference('css', 'skin_'.$this->nameID.'.css');
	}
	
	/**
	 * Adds a reference to a .css file
	 * @param $routeName the name of a static route, as e.g. defined in routes.php
	 * @param $path the name of your .css file
	 */
	public function addCssRouteReference($routeName, $path) {
		$this->cssRouteReferences[$routeName.$path] = array($routeName, $path);
	}
	
	public function getCssRouteReferences() {
		return $this->cssRouteReferences;
	}
	
	public function __toString() {
		return $this->getName();
	}
	
	/**
	 * Callback that is executed if this skin is used.
	 */
	public function onUseSkin() {
		
	}

	// GETTERS / SETTERS -------------------------------------------------------
	public function getNameID() {
		return $this->nameID;
	}

	public function getName() {
		return $this->name;
	}
}

?>