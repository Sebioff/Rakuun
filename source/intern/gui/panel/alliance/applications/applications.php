<?php

/**
 * Class to handle the alliance applications.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Applications extends GUI_Panel {
	const ACTION_NOTHING = 1;
	const ACTION_HIRE = 2;
	const ACTION_FIRE = 3;
	
	const STATUS_NEW = 1;
	const STATUS_HIRED = 2;
	const STATUS_FIRED = 3;
	const STATUS_JOINED_OTHER = 4;
	
	private $applications = array();
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/applications.tpl');
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$options['conditions'][] = array('status = ?', self::STATUS_NEW);
		$options['order'] = 'date DESC';
		$applications = Rakuun_DB_Containers::getAlliancesApplicationsContainer()->select($options);
		foreach ($applications as $application) {
			$list = new GUI_Control_RadioButtonList('application_'.$application->id);
			$hire = new GUI_Control_RadioButton('hire', self::ACTION_HIRE);
			$hire->setTitle('annehmen');
			$list->addItemRadiobutton($hire);
			$fire = new GUI_Control_RadioButton('fire', self::ACTION_FIRE);
			$fire->setTitle('ablehnen');
			$list->addItemRadiobutton($fire);
			$none = new GUI_Control_RadioButton('none', self::ACTION_NOTHING, true, 'nichts');
			$list->addItemRadiobutton($none);
			$this->addPanel($reason = new GUI_Control_TextArea('reason'.$application->id, '', 'Begründung'));
			$reason->setAttribute('rows', 3);
			$this->applications[] = array('options' => $list, 'record' => $application, 'reason' => $reason);
		}
		$this->params->applications = $this->applications;
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Übernehmen'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		foreach ($this->applications as $application) {
			$radiobuttons = $application['options']->getItems();
			$this->getModule()->addJsAfterContent('$("#'.$application['reason']->getID().'-container").hide();');
			$this->getModule()->addJsAfterContent('$("#'.$radiobuttons[1]->getID().'").click(function() { $("#'.$application['reason']->getID().'-container").show(); });');
			$this->getModule()->addJsAfterContent('$("#'.$radiobuttons[0]->getID().'").click(function() { $("#'.$application['reason']->getID().'-container").hide(); });');
			$this->getModule()->addJsAfterContent('$("#'.$radiobuttons[2]->getID().'").click(function() { $("#'.$application['reason']->getID().'-container").hide(); });');
		}
	}
	
	public function onSubmit() {
		if (Rakuun_GameSecurity::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_GameSecurity::GROUP_DEMO))
			$this->addError('Demo-User darf keine Mitglieder in seine Allianz aufnehmen.');
		
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		foreach ($this->applications as $application) {
			$user = $application['record']->user;
			$alliance = $application['record']->alliance;
			$application['record']->date = time();
			switch ($application['options']->getValue()) {
				case self::ACTION_FIRE:
					$igm = new Rakuun_Intern_IGM('Bewerbung bei ['.$alliance->tag.'] '.$alliance->name.' abgelehnt', $user);
					$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
					$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
					$message = Rakuun_User_Manager::getCurrentUser()->name.' hat deine Bewerbung bei '.$alliance->name.' abgelehnt.';
					if ($application['reason']->getValue())
						$message .= '<br />Begründung:<br />'.$application['reason']->getValue();
					$igm->setText($message);
					$igm->send();
					$application['record']->status = self::STATUS_FIRED;
					$application['record']->editor = Rakuun_User_Manager::getCurrentUser();
					$application['record']->editorNotice = $application['reason']->getValue();
					Rakuun_DB_Containers::getAlliancesApplicationsContainer()->save($application['record']);
					//save alliancehistory
					$alliancehistory = new Rakuun_Intern_Alliance_History($user, $alliance->name, Rakuun_Intern_Alliance_History::TYPE_UNACCEPTED);
					$alliancehistory->save();
				break;
				case self::ACTION_HIRE:
					$user->alliance = $alliance;
					Rakuun_DB_Containers::getUserContainer()->save($user);
					$igm = new Rakuun_Intern_IGM('Bewerbung bei ['.$alliance->tag.'] '.$alliance->name.' angenommen', $user);
					$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
					$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
					$igm->setText(
						Rakuun_User_Manager::getCurrentUser()->name.' hat soeben deine Allianzbewerbung angenommen.'
					);
					$igm->send();
					$application['record']->status = self::STATUS_HIRED;
					$application['record']->editor = Rakuun_User_Manager::getCurrentUser();
					Rakuun_DB_Containers::getAlliancesApplicationsContainer()->save($application['record']);
					// it's probably much faster to do this via SQL, but i don't wanna use raw queries again ;)
					$options['conditions'][] = array('user = ?', $user);
					$options['conditions'][] = array('status = ?', self::STATUS_NEW);
					$other_alliance_applications = Rakuun_DB_Containers::getAlliancesApplicationsContainer()->select($options);
					foreach ($other_alliance_applications as $other_application) {
						$other_application->status = self::STATUS_JOINED_OTHER;
						$other_application->date = time();
						Rakuun_DB_Containers::getAlliancesApplicationsContainer()->save($other_application);
					}
					//save alliancehistory
					$alliancehistory = new Rakuun_Intern_Alliance_History($user, $alliance->name, Rakuun_Intern_Alliance_History::TYPE_ACCEPTED);
					$alliancehistory->save();
				break;
				case self::ACTION_NOTHING:
					//do nothing
				break;
			}
		}
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>