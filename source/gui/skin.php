<?php

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