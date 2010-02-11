<?php

class Rakuun_Cronjob extends Module implements Scriptlet_Privileged {
	private $scripts = array();
	
	public function onConstruct() {
		parent::onConstruct();
		
		$this->addScript(new Rakuun_Cronjob_Script_DailyCleanup('daily_cleanup', 0, 0)); // daily at 00:00
		$this->addScript(new Rakuun_Cronjob_Script_Cleanup('cleanup', 6 * 60 * 60)); // every 6 hours
		$this->addScript(new Rakuun_Cronjob_Script_Tick('tick', 2 * 60)); // every 2 minutes
		$this->addScript(new Rakuun_Cronjob_Script_Fight('fight', 5 * 60)); // every 5 minutes
	}
	
	public function init() {
		parent::init();
		
		// FIXME App/Router currently don't respect Scriptlet_Privileged
		if (!$this->checkPrivileges())
			exit;
		
		foreach ($this->scripts as $script) {
			$cronjobRecord = Rakuun_DB_Containers::getCronjobsContainer()->selectByPK($script->getIdentifier());
			if (!$cronjobRecord) {
				$cronjobRecord = new DB_Record();
				$cronjobRecord->identifier = $script->getIdentifier();
			}
			
			if (!$script->requiresExecution($cronjobRecord->lastExecution))
				continue;
			
			$cronjobRecord->lastExecution = time();
			try {
				$executionStart = microtime(true);
				$script->execute();
				$cronjobRecord->lastExecutionDuration = microtime(true) - $executionStart;
				$cronjobRecord->lastExecutionSuccessful = true;
			}
			catch (Core_Exception $ce) {
				$cronjobRecord->lastExecutionSuccessful = false;
				try {
					Rakuun_Module::onError($ce->getTrace(), 'Cronjob: '.$script->getIdentifier().'. '.$ce->getMessage(), 'Fehler bei Cronjob');
				}
				catch (Core_Exception $ce) {
					echo 'An error occured in a cronjob script and sending an error mail failed!';
				}
			}
			
			Rakuun_DB_Containers::getCronjobsContainer()->save($cronjobRecord);
		}
	}
	
	private function addScript(Rakuun_Cronjob_Script $script) {
		$this->scripts[] = $script;
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return (
			$_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']
			|| ($user && Rakuun_TeamSecurity::get()->isInGroup($user, Rakuun_TeamSecurity::GROUP_ADMINS))
		);
	}
}

?>