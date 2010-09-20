<?php

class Rakuun_Intern_GUI_Panel_Polls_Poll extends GUI_Panel {
	private $poll = null;
	
	public function __construct($name, DB_Record $poll, $title = '') {
		$this->poll = $poll;
		parent::__construct($name, $title);		
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Panel_Text('question', $this->poll->question, 'Frage:'));
		$user = Rakuun_User_Manager::getCurrentUser();
		//did actual user already vote?
		$options['join'][] = 'polls_answers';
		$options['conditions'][] = array('polls_answers_users_assoc.user = ?', $user);
		$options['conditions'][] = array('polls_answers.id = polls_answers_users_assoc.answer');
		$options['conditions'][] = array('polls_answers.poll = ?', $this->poll->getPK());
		$count = Rakuun_DB_Containers::getPollsAnswersUsersAssocContainer()->count($options);
		//delete-link
		if (Rakuun_Intern_Alliance_Security::getForAlliance($user->alliance)->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_MODERATION)) {
			$this->addPanel($link = new GUI_Control_Link('delete', '-Umfrage Löschen-', $this->getModule()->getUrl(array('id' => $this->poll->getPK()))));
			$link->setConfirmationMessage('Diese Umfrage wirklich löschen?');
			if ($this->getModule()->getParam('id') == $this->poll->getPK()) {
				$this->poll->delete();
				return;
			}
		}
		//is poll still in its runtime?
		if ($this->poll->date + ($this->poll->runtime * 3600) > time()
			&& $count === 0
		)
			$this->initWithAnswers();
		else
			$this->initWithResult();		
	}
	
	protected function initWithAnswers() {
		$this->setTemplate(dirname(__FILE__).'/pollanswers.tpl');
		$answers = Rakuun_DB_Containers::getPollsAnswersContainer()->selectByPoll($this->poll);
		$this->addPanel($list = new GUI_Control_RadioButtonList('answers'));
		foreach ($answers as $answer) {
			$list->addItem($answer->text, $answer->getPK());
		}
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'vote!'));
	}
	
	protected function initWithResult() {
		$this->setTemplate(dirname(__FILE__).'/pollresult.tpl');
		$query = 'SELECT pa.id, pa.text, tmp.count
			FROM polls_answers pa
			LEFT JOIN (
				SELECT id AS pauaid, answer, count(answer) AS count
				FROM polls_answers_users_assoc
				GROUP BY answer
			) tmp ON tmp.answer = pa.id
			WHERE pa.poll = '.(int)$this->poll->getPK();
		//FIXME: Use DB_Containers instead of raw query as soon as possible
		$result = DB_Connection::get()->query($query);
		$answers = array();
		$sum = 0;
		while ($answer = mysql_fetch_object($result)) {
			$answers[$answer->text] = $answer->count ? $answer->count : 0;
			$sum += $answer->count;
		}
		$i = 0;
		if ($sum > 0) {
			foreach ($answers as $answer => $count) {
				$this->addPanel(new GUI_Panel_Text('answer'.$i, $answer));
				$this->addPanel(new GUI_Panel_Number('count'.$i, $count));
				$this->addPanel(new GUI_Panel_Number('percent'.$i, $count / $sum * 100));
				$i++;
			}
		}
		$this->params->anz = $i;
		$this->addPanel($plot = new GUI_Panel_Plot_Pie('plot', 400, 200));
		$plot->setData(array_values($answers));
		$plot->setDataNames(array_keys($answers));
	}
	
	public function onSubmit() {
		$selected = $this->answers->getValue();
		if (!$selected) {
			$this->addError('Keine Antwort ausgewählt.');
		}
		if ($this->hasErrors())
			return;
	
		$answer = new DB_Record();
		$answer->answer = $selected;
		$answer->user = Rakuun_User_Manager::getCurrentUser();
		$answer->date = time();
		Rakuun_DB_Containers::getPollsAnswersUsersAssocContainer()->save($answer);
		$this->getModule()->invalidate();
	}
}

?>