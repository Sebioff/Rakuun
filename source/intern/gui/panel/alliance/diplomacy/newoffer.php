<?php

/**
 * Panel that displays a form to establish a new relationship between two alliances.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Diplomacy_NewOffer extends Rakuun_Intern_GUI_Panel_Alliance_Diplomacy {
	
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/newoffer.tpl');
		$alliances = Rakuun_DB_Containers::getAlliancesContainer()->select(array('conditions' => array(array('id != ?', Rakuun_User_Manager::getCurrentUser()->alliance->getPK())), 'order' => 'name ASC'));
		$_alliances = array();
		foreach ($alliances as $alliance) {
			$_alliances[$alliance->id] = '['.$alliance->tag.'] '.$alliance->name;
		}
		$this->addPanel(new GUI_Control_DropDownBox('alliances', $_alliances, null, 'Empfänger'));
		$this->addPanel(new GUI_Control_DropDownBox('type', array(self::RELATION_AUVB => 'Angriffs- und Verteidigungsbündnis anbieten', self::RELATION_NAP => 'Nicht-Angriffs-Pakt anbieten', self::RELATION_WAR => 'Krieg erklären'), null, 'Typ'));
		$this->addPanel($notice = new GUI_Control_DigitBox('notice', 24, 'Kündigungsfrist'));
		$notice->setAttribute('maxlength', 2);
		$notice->addValidator(new GUI_Validator_Mandatory());
		$notice->addValidator(new GUI_Validator_MaxLength(2));
		$this->addPanel($text = new GUI_Control_TextArea('text'));
		$text->setTitle('Botschaft');
		$text->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Abschicken'));
	}
	
	public function onSubmit() {
		DB_Connection::get()->beginTransaction();
		$own = Rakuun_User_Manager::getCurrentUser()->alliance;
		$other = Rakuun_DB_Containers::getAlliancesContainer()->selectByIdFirst($this->alliances->getKey());
		
		if (!$other) {
			$this->addError('Keine Allianz ausgewählt');
		}
		
		//check for existing relationships
		$diplomacies = Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->select(array('conditions' => array(array('(alliance_active = ? and alliance_passive = ?) or (alliance_active = ? and alliance_passive = ?)', $own, $other, $other, $own))));
		if ($diplomacies) {
			$this->addError('Es besteht bereits eine diplomatische Beziehung zwischen diesen Allianzen. Diese muss erst beendet werden, bevor neue Bündnisse geschlossen / Kriege erklärt werden können.');
			DB_Connection::get()->rollback();
		}
		
		if ($this->hasErrors())
			return;
		
		//save the offer
		$offer = new DB_Record();
		$offer->alliance_active = $own;
		$offer->alliance_passive = $other;
		$offer->text = $this->text;
		$offer->type = $this->type->getKey();
		$offer->notice = $this->notice;
		$offer->status = $this->type->getKey() == self::RELATION_WAR ? self::STATUS_ACTIVE : self::STATUS_NEW;
		$offer->date = time();
		Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->save($offer);
		//inform the privileged users of the other alliance
		$users = Rakuun_Intern_Alliance_Security::getForAllianceById($other)->getPrivilegedUsers(Rakuun_Intern_Alliance_Security::PRIVILEGE_DIPLOMACY);
		$allianceLink = new Rakuun_GUI_Control_AllianceLink('alliancelink', $own);
		$diplomacyLink = new GUI_Control_Link('diplomacylink', 'Diplomatie', App::get()->getInternModule()->getSubmodule('alliance')->getSubmodule('diplomacy')->getURL());
		if ($this->type->getKey() == self::RELATION_WAR) {
			foreach ($users as $user) {
				$igm = new Rakuun_Intern_IGM('Kriegserklärung!', $user);
				$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
				$igm->setText(
					'Deiner Allianz wurde von '.$allianceLink->render().' der Krieg erklärt!<br />' .
					$diplomacyLink->render()
				);
				$igm->send();
			}
			$this->setSuccessMessage('Der Krieg wurde erklärt!');
		} else {
			foreach ($users as $user) {
				$igm = new Rakuun_Intern_IGM('Neues Diplomatieangebot', $user);
				$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
				$igm->setText(
					$allianceLink->render().' möchte mit euch verhandeln.<br />' .
					$diplomacyLink->render()
				);
				$igm->send();
			}
			$this->setSuccessMessage('Das Angebot wurde übermittelt.');
		}
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>