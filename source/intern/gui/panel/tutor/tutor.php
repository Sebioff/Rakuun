<?php

class Rakuun_Intern_GUI_Panel_Tutor extends GUI_Panel {
	private $level = array();
	
	public function __construct($name, $title = '') {
		parent::__construct($name, $title);
		$user = Rakuun_User_Manager::getCurrentUser();
		
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Start());
		
		// build up for first economy
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Build1());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Ressources1());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_People1());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Ressources2());
		
		// fix for demo account
		if (Rakuun_TeamSecurity::get()->isInGroup($user, Rakuun_TeamSecurity::GROUP_DEVELOPER))
			$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Profile());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Build2());
		
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Sitter());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Irc());
		
		// start to produce energy and people
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Techtree());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Buildflab());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Watertechnic());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Energy());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_People());
		
		// first military
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Firstmilitary());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Attdef());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Map());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Spydrones());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Warsim());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Attdeforder());
		
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Alliance());
		
		// additional buildings
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Satisfaction());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Trade());
		
		// advanced military
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tegos());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Advancedmilitary());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Citywall());
		
		// some more Tipps
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Tickets());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Sensorbay());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Goal());
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Faq());
		
		$this->addLevel(new Rakuun_Intern_GUI_Panel_Tutor_Level_Finish());
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/tutor.tpl');
		$this->addPanel($image = new GUI_Panel_Image('detlef', Router::get()->getStaticRoute('images', 'detlef.png'), 'Detlef'));
		$image->setAttribute('style', 'float: left; margin-right: 0.5em;');
		$this->params->level = $this->getActualLevel();
		if ($this->params->level != reset($this->level)) {
			$this->addPanel($back = new GUI_Control_SubmitButton('back', '&lt;-'));
			$back->setTitle('Zurück');
			$this->addPanel($first = new GUI_Control_SubmitButton('first', '&laquo;'));
			$first->setTitle('Zurück zum Anfang');
		}
		if ($this->params->level == end($this->level)) {
			$this->addPanel($end = new GUI_Control_SubmitButton('end', 'Beenden'));
			$end->setTitle('Das Tutorial beenden');
		} else {
			if ($this->params->level->completed()) {
				$this->addPanel($next = new GUI_Control_SubmitButton('next', '-&gt;'));
				$next->setTitle('Weiter');
			}
			$this->addPanel($last = new GUI_Control_SubmitButton('last', '&raquo;'));
			$last->setTitle('Ans Ende springen');
		}
	}
	
	private function getActualLevel() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$levelDB = Rakuun_DB_Containers::getTutorContainer()->selectByUserFirst($user);
		if (!$levelDB)
			return reset($this->level);
		
		foreach ($this->level as $level) {
			if ($level->getInternal() == $levelDB->level)
				return $level;
		}
	}
	
	private function addLevel(Rakuun_Intern_GUI_Panel_Tutor_Level $level) {
		if ($last = end($this->level))
			$last->setNext($level);
		else
			$last = null;
		$level->setLast($last);
		$this->level[] = $level;
	}
	
	public function onNext() {
		if ($this->params->level->completed()) {
			$this->params->level->finish();
			$this->getModule()->invalidate();
		}
	}
	
	public function onBack() {
		$this->params->level->rewind();
		$this->getModule()->invalidate();
	}
	
	public function onFirst() {
		Rakuun_DB_Containers::getTutorContainer()->deleteByUser(Rakuun_User_Manager::getCurrentUser());
		$this->getModule()->invalidate();
	}
	
	public function onLast() {
		end($this->level)->finish();
		$this->getModule()->invalidate();
	}
	
	public function onEnd() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->tutorial = false;
		Rakuun_User_Manager::update($user);
		$this->getModule()->invalidate();
	}
}
?>