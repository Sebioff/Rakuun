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

class Rakuun_Index_Panel_Activation extends GUI_Panel {
	private $hasBeenActivated = false;
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/activation.tpl');
		
		$activationCode = $this->getModule()->getParam('code');
		if ($activation = Rakuun_DB_Containers::getUserActivationContainer()->selectByCodeFirst($activationCode)) {
			$activation->user->activationTime = time();
			$activation->user->save();
			Rakuun_DB_Containers::getUserActivationContainer()->delete($activation);
			// FIXME this is not quite ideal, the user might be locked for different reasons...
			// unlock the user if neccessary (might be locked for not activating his account)
			if ($activation->user->isLocked())
				Rakuun_User_Manager::unlock($activation->user);
			$this->hasBeenActivated = true;
		}
		else {
			$this->addError('Account konnte nicht aktiviert werden - falscher Aktivierungscode oder bereits aktiviert.');
		}
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function hasBeenActivated() {
		return $this->hasBeenActivated;
	}
}

?>