<?php

require_once dirname(__FILE__).'/3rdparty/Net/SSH2.php';

class Rakuun_Intern_GUI_Panel_Admin_RoundControl extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/roundcontrol.tpl');
		
		$this->addPanel($date = new GUI_Control_DatePicker('date', 0, 'Datum'));
		$date->addValidator(new GUI_Validator_Mandatory());
		// TODO needs "TimePicker"
		$this->addPanel($hour = new GUI_Control_DigitBox('hour', 18, 'Stunde', 0, 23));
		$hour->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('set_start', 'Start der Runde'));
		$this->addPanel(new GUI_Control_SubmitButton('set_end', 'Ende der Runde'));
	}
	
	public function onSetStart() {
		$startTime = $this->date->getValue() + $this->hour->getValue() * 60 * 60;
		$this->setConfigValue('RAKUUN_ROUND_STARTTIME', $startTime);
	}
	
	public function onSetEnd() {
		$endTime = $this->date->getValue() + $this->hour->getValue() * 60 * 60;
		$this->setConfigValue('RAKUUN_ROUND_ENDTIME', $endTime);
	}
	
	private function setConfigValue($key, $value) {
		$ssh = new Net_SSH2(RAKUUN_SSH_ADDRESS);
		if (!$ssh->login(RAKUUN_SSH_USER, RAKUUN_SSH_PASSWORD)) {
			$this->addError('SSH login failed');
		}
		
		if ($this->hasErrors())
			return;
		
		$ssh->exec('chmod 666 www/Rakuun/config/revision.php');
		$file = PROJECT_PATH.'/config/revision.php';
		$file_contents = file_get_contents($file);
		
		$fh = fopen($file, 'w');
		$file_contents = preg_replace('=\(\''.$key.'\', \d+\)=', '(\''.$key.'\', '.$value.')', $file_contents);
		fwrite($fh, $file_contents);
		fclose($fh);
		$ssh->exec('chmod 644 www/Rakuun/config/revision.php');
	}
}

?>