<?php

/**
 * Panel to send ressources to a player
 *
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Trade extends GUI_Panel {
	// status of the submit
	const IDLE = 0;
	const CALC = 1;
	const COMMIT = 2;
	
	private $user = null;
	
	public function __construct($name, $title = '', Rakuun_DB_User $user = null) {
		parent::__construct($name, $title);
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->setTemplate(dirname(__FILE__).'/trade.tpl');
		
		$this->addPanel($recipient = new Rakuun_GUI_Control_UserSelect('recipient', $this->user, 'Empfänger'));
		$recipient->addValidator(new GUI_Validator_Mandatory());
		
		$this->addPanel($iron = new GUI_Control_DigitBox('iron', 0, 'Eisen'));
		$iron->addValidator(new GUI_Validator_Mandatory());
		
		$this->addPanel($beryllium = new GUI_Control_DigitBox('beryllium', 0, 'Beryllium'));
		$beryllium->addValidator(new GUI_Validator_Mandatory());
		
		$this->addPanel($energy = new GUI_Control_DigitBox('energy', 0, 'Energie'));
		$energy->addValidator(new GUI_Validator_Mandatory());
		
		$this->addPanel($message = new GUI_Control_TextBox('message', '', 'Verwendungszweck'));
		$message->addValidator(new GUI_Validator_MaxLength(50));
		
		$this->addPanel(new GUI_Panel_Number('tradelimit', ($user->buildings->moleculartransmitter * Rakuun_Intern_Production_Building_Moleculartransmitter::TRADE_VOLUME * RAKUUN_TRADELIMIT_MULTIPLIER - $user->tradelimit), 'Du kannst heute noch so viele Ressourcen erhalten:'));
		
		$this->addPanel($submit = new GUI_Control_SubmitButton('submit', 'Berechnen'));
		
		$this->addPanel($status = new GUI_Control_Hiddenbox('status', self::IDLE));
	}
	
	/**
	 * On first submit show the tradevolums (inclusive costs)
	 * On second submit transfer the ressources to the recipient
	 */
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		// calculate costs and show them
		if ($this->status->getValue() == self::IDLE) {
			$this->status->setValue(self::CALC);
			$costs = new Rakuun_Intern_GUI_Panel_Trade_ShowCosts('showcosts', 'Handeln...');
			$costs->setTradeParameters($this->recipient->getUser(), $this->iron->getValue(), $this->beryllium->getValue(), $this->energy->getValue(), $this->message->getValue());
			$this->addPanel(new Rakuun_GUI_Panel_Box('costs', $costs));
			$this->submit->setValue('Abschicken');
		} else if ($this->status->getValue() == self::CALC) {
			$recipient = $this->recipient->getUser();
			$this->status->setValue(self::IDLE);
			$this->submit->setValue('Berechnen');
			$sender = Rakuun_User_Manager::getCurrentUser();
			$tradevolume = $this->iron->getValue() + $this->beryllium->getValue() + $this->energy->getValue();
			
			// whole costs for sender
			$ironcosts = $this->iron->getValue() * 1.1;
			$berylliumcosts = $this->beryllium->getValue() * 1.1;
			$energycosts = $this->energy->getValue() * 2 + ($this->iron->getValue() + $this->beryllium->getValue()) / 2;
			
			// check if enough ressources are available
			if ($ironcosts > $sender->ressources->iron)
				$this->addError('So viel Eisen besitzt du nicht');
			if ($berylliumcosts > $sender->ressources->beryllium)
				$this->addError('So viel Beryllium besitzt du nicht');
			if ($energycosts > $sender->ressources->energy)
				$this->addError('So viel Energie besitzt du nicht');
			
			$tradelimit = $recipient->buildings->moleculartransmitter * Rakuun_Intern_Production_Building_Moleculartransmitter::TRADE_VOLUME * RAKUUN_TRADELIMIT_MULTIPLIER - $recipient->tradelimit;
			if ($tradelimit < $tradevolume)
				$this->addError('Der Empfänger kann nur noch '.$tradelimit.' Ressourcen erhalten');
			if ($sender->id == $recipient->id)
				$this->addError('Sich selbst Ressourcen zu schicken macht wohl wenig Sinn, oder? ;)');
			
			if ($this->iron->getValue() + $recipient->ressources->iron > $recipient->ressources->getCapacityIron()) {
				$capacity = $recipient->ressources->getCapacityIron() - $recipient->ressources->iron;
				$this->addError($recipient->name.' kann nur noch '.$capacity.' Eisen empfangen.');
				$this->iron->setValue($capacity);
			}
			if ($this->beryllium->getValue() + $recipient->ressources->beryllium > $recipient->ressources->getCapacityBeryllium()) {
				$capacity = $recipient->ressources->getCapacityBeryllium() - $recipient->ressources->beryllium;
				$this->addError($recipient->name.' kann nur noch '.$capacity.' Beryllium empfangen.');
				$this->beryllium->setValue($capacity);
			}
			if ($this->energy->getValue() + $recipient->ressources->energy > $recipient->ressources->getCapacityEnergy()) {
				$capacity = $recipient->ressources->getCapacityEnergy() - $recipient->ressources->energy;
				$this->addError($recipient->name.' kann nur noch '.$capacity.' Energie empfangen.');
				$this->energy->setValue($capacity);
			}
			
			if ($sender->isInNoob())
				$this->addError('Du darfst dich nicht im Noobschutz befinden, um den Molekulartransmitter benutzen zu können');
			
			if (!Rakuun_GameSecurity::get()->hasPrivilege($recipient, Rakuun_GameSecurity::PRIVILEGE_USE_MOLECULARTRANSMITTER))
				$this->addError('Dieser Spieler kann den Molekulartransmitter nicht benutzen.');
			
			// we have to check here for another time
			if ($this->hasErrors())
				return;
				
			//TODO check recipient is not sitter
			DB_Connection::get()->beginTransaction();
			$recipient->tradelimit = $recipient->tradelimit + $tradevolume;
			$recipient->ressources->raise($this->iron->getValue(), $this->beryllium->getValue(), $this->energy->getValue(), 0);
			$sender->ressources->lower($ironcosts, $berylliumcosts, $energycosts, 0);
			
			// send information message to the recipient
			$igm = new Rakuun_Intern_IGM('Handel', $this->recipient->getUser(), '', Rakuun_Intern_IGM::TYPE_TRADE);
			$igm->setSender($sender);
			$message = 'Du hast von '.$sender->name.' folgende Ressourcen erhalten:
				<br />'.$this->iron->getValue().' Eisen
				<br />'.$this->beryllium->getValue().' Beryllium
				<br />'.$this->energy->getValue().' Energie';
			if ($this->message->getValue()) {
				$message .= '<br />Verwendungszweck:<br />'.$this->message->getValue();
			}
			$igm->setText($message);
			$igm->send();
			Rakuun_User_Manager::update($recipient);
			Rakuun_Intern_Log_Ressourcetransfer::log($recipient, Rakuun_Intern_Log::ACTION_RESSOURCES_TRADE, $sender, $this->iron->getValue(), $this->beryllium->getValue(), $this->energy->getValue());
			DB_Connection::get()->commit();
			$this->setSuccessMessage('Ressourcen erfolgreich übertragen');			
		}
	}
}

?>