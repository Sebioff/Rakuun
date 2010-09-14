<?php

class Rakuun_Intern_Module_Highscores extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Highscores');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/highscores.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('userbox', new Rakuun_Intern_GUI_Panel_User_Highscore('userhighscore', Rakuun_DB_Containers::getUserContainer()), 'User Highscore'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('alliancebox', new Rakuun_Intern_GUI_Panel_Alliance_Highscore('alliancehighscore', Rakuun_DB_Containers::getAlliancesContainer()), 'Allianz Highscore'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('quests', new Rakuun_Intern_GUI_Panel_User_QuestLog('quests'), 'Quests'));
	}
}

?>