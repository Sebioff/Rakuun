<?php

/**
 * Panel to activate users who have not get an activationmail
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_User_Activate extends GUI_Panel {
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/activate.tpl');
		
		// get only users who are not activated
		$notactivatedusers = array();
		$options['conditions'][] = array('activation_time = 0');
		foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $user) {
			$notactivatedusers[$user->getPK()] = $user->nameUncolored;
		}
		$this->addPanel(new GUI_Control_DropDownBox('notactivatedusers', $notactivatedusers));
		
		$this->addPanel(new GUI_Control_SubmitButton('activate', 'User aktivieren'));
	}
	
	public function onActivate() {
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->notactivatedusers->getKey());
		if (!$user) {
			$this->addError('kein Spieler ausgewählt');
		}
		
		if ($this->hasErrors())
			return;
		
		Rakuun_DB_Containers::getUserActivationContainer()->deleteByUser($user);
		
		$igm = new Rakuun_Intern_IGM('Aktivierung!', $user);
		$igm->setText(
			'Hi '.$user->name.',
			<br/>
			Dein Account wurde manuell aktiviert!
			<br/>
			Viel Spass bei Rakuun!'
		);
		$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
		$igm->send();
		
		$user->activationTime = time();
		$user->save();
	}
}
?>