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

/**
 * Panel to add a poll.
 */
class Rakuun_Intern_GUI_Panel_Polls_AddPoll extends GUI_Panel {
	private $polltype = null;
	
	public function __construct($name, $type, $title = '') {
		$this->polltype = $type;
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/addpoll.tpl');
		$this->addPanel($question = new GUI_Control_TextBox('question'));
		$question->addValidator(new GUI_Validator_Mandatory());
		$question->addValidator(new GUI_Validator_MaxLength(150));
		$question->setAttribute('maxlength', 150);
		$question->setTitle('Frage:');
		$this->addPanel($runtime = new GUI_Control_TextBox('runtime'));
		$runtime->addValidator(new GUI_Validator_Mandatory());
		$runtime->addValidator(new GUI_Validator_Digits(1, 7 * 24));
		$runtime->setTitle('Laufzeit (in Stunden):');
		$runtime->setValue(24);
		if (!isset($_SESSION['poll-answer-count']))
			$_SESSION['poll-answer-count'] = 2;
		$this->addAnswers();
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
		$this->addPanel(new GUI_Control_SubmitButton('addanswer', 'Antwortfeld hinzufügen'));
	}
	
	// private functions
	protected function addAnswers() {
		for ($i = 0; $i < $_SESSION['poll-answer-count']; $i++) {
			$this->addPanel($answer = new GUI_Control_TextBox('answer'.$i));
			$answer->addValidator(new GUI_Validator_Mandatory());
			$answer->addValidator(new GUI_Validator_MaxLength(150));
			$answer->setAttribute('maxlength', 150);
			$answer->setTitle('Antwort:');
		}
	}
	
	// callbacks
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$poll = new DB_Record();
		$poll->type = $this->polltype;
		if ($this->polltype == Rakuun_Intern_GUI_Panel_Polls::POLL_ALLIANCE)
			$poll->alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		if ($this->polltype == Rakuun_Intern_GUI_Panel_Polls::POLL_META)
			$poll->meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
		$poll->question = $this->question;
		$poll->date = time();
		$poll->runtime = $this->runtime;
		Rakuun_DB_Containers::getPollsContainer()->save($poll);
		for ($i = 0; $i < $_SESSION['poll-answer-count']; $i++) {
			$answer = new DB_Record();
			$answer->poll = $poll;
			$answer->text = $this->{'answer'.$i}->getValue();
			Rakuun_DB_Containers::getPollsAnswersContainer()->save($answer);
		}
		$_SESSION['poll-answer-count'] = 2;
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
	
	public function onAddanswer() {
		$this->addPanel($answer = new GUI_Control_TextBox('answer'.$_SESSION['poll-answer-count']));
		$answer->addValidator(new GUI_Validator_Mandatory());
		$answer->addValidator(new GUI_Validator_MaxLength(150));
		$answer->setAttribute('maxlength', 150);
		$answer->setTitle('Antwort:');
		$_SESSION['poll-answer-count']++;
	}
}

?>