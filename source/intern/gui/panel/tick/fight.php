<?php

/**
 * Panel to show the next Fight Tick.
 *
 * @author dr.dent
 */
class Rakuun_Intern_GUI_panel_Tick_Fight extends GUI_Panel {
		
	public function init() {
		parent::init();
		//lasttime() + interval - time()
		$this->setTemplate(dirname(__FILE__).'/fight.tpl');
		$options['conditions'][] = array('identifier = ?', 'fight');
		$fightCronjob = Rakuun_DB_Containers::getCronjobsContainer()->selectFirst($options);
		$lastExecution = ($fightCronjob) ? $fightCronjob->lastExecution : 0;
		$this->addPanel($countdown = new Rakuun_GUI_Panel_CountDown('fightcountdown', $lastExecution + Rakuun_Cronjob::FIGHT_DURATION , 'Kämpfe laufen'));
		$countdown->enableHoverInfo(true);
	}
}

?>