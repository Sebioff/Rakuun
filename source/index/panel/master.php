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

class Rakuun_Index_Panel_Master extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/master.tpl');
		
		$this->addPanel($key = new GUI_Control_PasswordBox('key', null, 'Key'));
		$key->addValidator(new GUI_Validator_Mandatory());
		$key->setFocus();
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'OK'));
	}
	
	public function onSubmit() {
		if (md5($this->key->getValue()) == MASTERKEY)
			setcookie('mk_cookie', $this->key->getValue(), time() + 60 * 60 * 24 * 356 * 5);
	}
}

?>