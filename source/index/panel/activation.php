<?php

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
			if ($activation->user->îsLocked())
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