<?php

require_once dirname(__FILE__).'/3rdparty/Net/SSH2.php';

class Rakuun_Intern_GUI_Panel_Admin_Update extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/update.tpl');
		$this->addPanel(new GUI_Control_CheckBox('create_news', '', true, 'Newseintrag erstellen'));
		$this->addPanel(new GUI_Control_SubmitButton('update', 'Spiel aktualisieren'));
		$this->addPanel(new GUI_Panel_Text('update_log', '', 'Updatelog'));
	}
	
	public function onUpdate() {
		$ssh = new Net_SSH2(RAKUUN_SSH_ADDRESS);
		if (!$ssh->login(RAKUUN_SSH_USER, RAKUUN_SSH_PASSWORD)) {
			$this->addError('SSH login failed');
		}
		
		if ($this->hasErrors())
			return;
			
		$log = '';
		
		// enable maintenance mode
		$log .= '<br /><strong>Enabling maintenance mode...</strong><br />';
		App::get()->enableMaintenanceMode();
		
		// update core
		$this->params->conflicts = false;
		$log .= '<br /><strong>Updating CORE...</strong><br />';
		$updateActions = explode("\n", $ssh->exec('svn update www/v4/CORE'));
		foreach ($updateActions as $action) {
			if (isset($action[0]) && $action[0] == 'C') {
				$log .= '<span style="color:#ff0000">'.$action.'</span><br />';
				$this->params->conflicts = true;
			}
			else {
				$log .= $action.'<br />';
			}
		}
		
		// update rakuun
		$log .= '<br /><strong>Updating Rakuun...</strong><br />';
		$updateActions = explode("\n", $ssh->exec('svn update www/v4/Rakuun'));
		foreach ($updateActions as $action) {
			if (isset($action[0]) && $action[0] == 'C') {
				$log .= '<span style="color:#ff0000">'.$action.'</span><br />';
				$this->params->conflicts = true;
			}
			else {
				$log .= $action.'<br />';
			}
		}
		
		// get new revision number
		$revisionNumber = PROJECT_VERSION;
		preg_match('(\d+)', $updateActions[count($updateActions) - 2], $matches);
		$revisionNumber = $matches[0];
		
		// FIXME this update-action needs to be available in CORE somewhere
		// clear global cache
		$GLOBALS['cache']->clearAll();
		Core_MigrationsLoader::load();
		
		// disable maintenance mode
		$log .= '<br /><strong>Disabling maintenance mode...</strong><br />';
		App::get()->enableMaintenanceMode(false);
		
		$this->updateLog->setText($log);
		
		if ($revisionNumber == PROJECT_VERSION)
			return;
		
		if ($this->createNews->getSelected()) {
			// get changes
			$history = explode("\n", $ssh->exec('svn log www/v4/Rakuun -r '.$revisionNumber.':'.(PROJECT_VERSION + 1)));
			$formatHistory = $this->formatHistory($history);
			
			// add news entry
			$newsEntry = new DB_Record();
			$newsEntry->subject = 'Update';
			$newsEntry->text = 'Das Spiel wurde gerade aktualisiert. Folgende Änderungen wurden vorgenommen:<br/><br/>'.$formatHistory;
			$newsEntry->time = time();
			Rakuun_DB_Containers::getNewsContainer()->save($newsEntry);
		}
		
		// update revision number
		$ssh->exec('chmod 666 www/v4/Rakuun/config/revision.php');
		$file = PROJECT_PATH.'/config/revision.php';
		$file_contents = file_get_contents($file);
		
		$fh = fopen($file, 'w');
		$file_contents = preg_replace('=\(\'PROJECT_VERSION\', \d+\)=', '(\'PROJECT_VERSION\', '.$revisionNumber.')', $file_contents);
		fwrite($fh, $file_contents);
		fclose($fh);
		$ssh->exec('chmod 644 www/v4/Rakuun/config/revision.php');
	}
	
	private function formatHistory(array $history) {
		$revision = -1;
		$revisionHistory = '';
		$formatHistory = '';
		foreach ($history as $historyEntry) {
			if ($revision == -1) {
				preg_match('=r(\d+) \| .* line=', $historyEntry, $matches);
				if (isset($matches[1]))
					$revision = $matches[1];
			}
			else {
				preg_match('=-{15,}=', $historyEntry, $matches);
				if (isset($matches[0])) {
					$formatHistory .= '<strong>revision '.$revision.'</strong>:<ul>'.$revisionHistory.'</ul><br/>';
					$revision = -1;
					$revisionHistory = '';
					continue;
				}
				
				if ($historyEntry)
					$revisionHistory .= '<li>'.$historyEntry.'</li>';
			}
		}
		
		return $formatHistory;
	}
}

?>