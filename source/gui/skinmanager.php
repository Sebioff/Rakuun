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
 * Manages all available skins. Unknown functions are delegated to the currently
 * selected skin.
 */
class Rakuun_GUI_Skinmanager {
	private static $instance = null;
	private $currentSkin = '';
	private $skins = array();
	
	public function __construct() {
		// TODO: probably it's not neccessary to construct all the skin classes here.
		// maybe only save the names of the classes?
		//$this->addSkin($default = new Rakuun_GUI_Skin_Space2());
		$this->addSkin($default = new Rakuun_GUI_Skin_Tech());
		//$this->addSkin(new Rakuun_GUI_Skin_Original());
		$this->setCurrentSkin($default->getNameID());
	}
	
	public function addSkin(Rakuun_GUI_Skin $skin) {
		$this->skins[$skin->getNameID()] = $skin;
	}
	
	public function setCurrentSkin($skinNameID) {
		if (isset($this->skins[$skinNameID])) {
			$this->currentSkin = $skinNameID;
			$this->getCurrentSkin()->onUseSkin();
		}
	}
	
	/**
	 * @return Rakuun_GUI_Skin
	 */
	public function getCurrentSkin() {
		return $this->skins[$this->currentSkin];
	}
	
	public function getAllSkins() {
		return $this->skins;
	}
	
	public function getCurrentSkinClass() {
		return 'skin_'.$this->currentSkin;
	}
	
	/**
	 * Delegate unknown functions to the currently selected skin.
	 */
	public function __call($name, $params) {
		return call_user_func_array(array($this->getCurrentSkin(), $name), $params);
	}
	
	public static function get() {
		return (self::$instance) ? self::$instance : self::$instance = new self();
	}
}

?>