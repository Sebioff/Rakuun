<?php

/**
 * Panel to transfer ressources from user to alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Account_Deposit extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/deposit.tpl');
		$this->addPanel($iron = new GUI_Control_DigitBox('iron', 0));
		$iron->setTitle('Eisen:');
		$iron->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($beryllium = new GUI_Control_DigitBox('beryllium', 0));
		$beryllium->setTitle('Beryllium:');
		$beryllium->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($energy = new GUI_Control_DigitBox('energy', 0));
		$energy->setTitle('Energie:');
		$energy->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($people = new GUI_Control_DigitBox('people', 0));
		$people->setTitle('Leute:');
		$people->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'einzahlen'));
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$ressources = $user->ressources;
		if ($this->iron->getValue() > $ressources->iron)
			$this->addError('So viel Eisen hast du nicht.');
		if ($this->beryllium->getValue() > $ressources->beryllium)
			$this->addError('So viel Beryllium hast du nicht.');
		if ($this->energy->getValue() > $ressources->energy)
			$this->addError('So viel Energie hast du nicht.');
		if ($this->people->getValue() > $ressources->people)
			$this->addError('So viele Leute hast du nicht.');
		if (!($user->buildings->moleculartransmitter > 0))
			$this->addError('Du benötigste einen Molekulartransmitter, um in die Allianzkasse einzahlen zu können.');
		if ($user->isInNoob())
			$this->addError('Du darfst dich nicht im Noobschutz befinden, um in die Allianzkasse einzahlen zu können');
			
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		$ressources->lower($this->iron->getValue(), $this->beryllium->getValue(), $this->energy->getValue(), $this->people->getValue());
		$user->alliance->raise($this->iron->getValue(), $this->beryllium->getValue(), $this->energy->getValue(), $this->people->getValue());
		$log = new DB_Record();
		$log->alliance = $user->alliance;
		$log->sender = $user;
		$log->iron = $this->iron->getValue();
		$log->beryllium = $this->beryllium->getValue();
		$log->energy = $this->energy->getValue();
		$log->people = $this->people->getValue();
		$log->date = time();
		$log->type = Rakuun_Intern_GUI_Panel_Alliance_Account::TYPE_USER_TO_ALLIANCE;
		Rakuun_DB_Containers::getAlliancesAccountlogContainer()->save($log);
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Transfer erfolgreich.');
		$this->getModule()->invalidate();
	}
}

?>