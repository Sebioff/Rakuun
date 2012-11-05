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

class Rakuun_GUI_Control_UserSelect extends GUI_Control_TextBox {
	public function __construct($name, Rakuun_DB_User $defaultValue = null, $title = '') {
		parent::__construct($name, $defaultValue ? $defaultValue->nameUncolored : null, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->getModule()->addJsRouteReference('js', 'control/autocomplete/jquery.autocomplete.js');
		$this->getModule()->addCssRouteReference('css', 'control/autocomplete/jquery.autocomplete.css');
	}
	
	protected function validate() {
		parent::validate();
		
		if ($error = $this->validation())
			$this->errors[] = $error;
		
		return $this->errors;
	}
	
	/**
	 * @return Rakuun_DB_User
	 */
	public function getUser() {
		return Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->getValue());
	}
	
	public function render() {
		$this->addJS($this->generateJS());
		return parent::render();
	}
	
	protected function generateJS() {
		return sprintf('$("#%s").autocomplete("%s", {width: 260, autoFill: true, max: 10});', $this->getID(), App::get()->getUserSelectScriptletModule()->getURL());
	}
	
	protected function validation() {
		if ($this->getValue()) {
			if (!$this->getUser())
				$this->errors[] = 'Spieler existiert nicht: '.$this->getValue();
		}
	}
}

class Rakuun_GUI_Control_UserSelect_Scriptlet extends Scriptlet {
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('name LIKE ?', $this->getParam('q').'%');
		if ($this->getParam('limit') !== null)
			$options['limit'] = $this->getParam('limit');
		foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $user) {
			echo $user->nameUncolored."\n";
		}
	}
}

?>