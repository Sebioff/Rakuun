<?php

class Rakuun_Intern_GUI_Panel_Polls extends GUI_Panel {
	const POLL_GLOBAL = 0;
	const POLL_ALLIANCE = 1;
	const POLL_META = 2;
	const POLL_ADMINS = 3;
	
	private $polltype = null;
	
	public function __construct($name, $type, $title = '') {
		$this->polltype = $type;
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/polls.tpl');
		$options['conditions'][] = array('type = ?', $this->polltype);
		if ($this->polltype == self::POLL_ALLIANCE)
			$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$polls = Rakuun_DB_Containers::getPollsContainer()->select($options);
		foreach ($polls as $poll) {
			$this->addPanel(new Rakuun_Intern_GUI_Panel_Polls_Poll('poll'.$poll->getPK(), $poll));
		}
	}
}

?>