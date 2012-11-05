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

require_once dirname(__FILE__).'/3rdparty/Net/SSH2.php';
require_once dirname(__FILE__).'/3rdparty/Twitter/twitter.class.php';

class Rakuun_Intern_GUI_Panel_Admin_Update extends GUI_Panel {
	const STATE_PREPARING = 1;
	const STATE_REVIEWING = 2;
	
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/update.tpl');
		$this->addPanel(new GUI_Control_CheckBox('create_news', '', true, 'Newseintrag erstellen'));
		$this->addPanel(new GUI_Control_SubmitButton('update', 'Vorbereiten...'));
		$this->addPanel($state = new GUI_Control_HiddenBox('state', self::STATE_PREPARING));
		$this->addPanel(new GUI_Panel_Text('update_log', '', 'Updatelog'));
	}
	
	public function onUpdate() {
		$ssh = new Net_SSH2(RAKUUN_SSH_ADDRESS);
		if (!$ssh->login(RAKUUN_SSH_USER, RAKUUN_SSH_PASSWORD)) {
			$this->addError('SSH login failed');
		}
		
		if ($this->hasErrors()) {
			$this->state->setValue(self::STATE_PREPARING);
			$this->update->setValue('Vorbereiten...');
			return;
		}
		else {
			if ($this->createNews->getSelected()) {
				$history = explode("\n", $ssh->exec('svn log '.RAKUUN_SVN_PROJECT_PATH.' -r BASE:HEAD'));
				$formatHistory = $this->formatHistory($history);
				$this->addPanel(new GUI_Control_TextArea('newstext', 'Das Spiel wurde gerade aktualisiert. Folgende Änderungen wurden vorgenommen:'."\n".'<br/>'."\n".'<br/>'."\n".$formatHistory, 'Newseintrag'));
				$this->addPanel($tweet = new GUI_Control_TextArea('tweet', 'Update: '.$formatHistory, 'Tweet'));
				$tweet->setAttribute('rows', 5);
				// FIXME remove duplicated code, copied from shoutbox
				$tweet->addJS(sprintf(
					'
						function shoutboxCountCharactersDown() {
							if ($("#%1$s").val().length > %2$d)
								$("#%1$s").val($("#%1$s").val().substring(0, %2$d));
							$("#shoutbox_characters_left").val(%2$d - $("#%1$s").val().length);
						}
						
						$("#%1$s").keypress(function() {
							shoutboxCountCharactersDown();
						}).keyup(function() {
							shoutboxCountCharactersDown();
						}).change(function() {
							shoutboxCountCharactersDown();
						});
					',
					$tweet->getID(), 140
				));
			}
		}
		
		if ($this->state->getValue() == self::STATE_PREPARING) {
			$this->state->setValue(self::STATE_REVIEWING);
			$this->update->setValue('Spiel aktualisieren');
			return;
		}
		else {
			$this->state->setValue(self::STATE_PREPARING);
		}
		
		$log = '';
		
		// enable maintenance mode
		$log .= '<br /><strong>Enabling maintenance mode...</strong><br />';
		App::get()->enableMaintenanceMode();
		
		// update core
		$this->params->conflicts = false;
		$log .= '<br /><strong>Updating CORE...</strong><br />';
		$updateActions = explode("\n", $ssh->exec('svn update '.RAKUUN_SVN_CORE_PATH));
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
		$updateActions = explode("\n", $ssh->exec('svn update www/Rakuun'));
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
			$history = explode("\n", $ssh->exec('svn log '.RAKUUN_SVN_PROJECT_PATH.' -r '.$revisionNumber.':'.(PROJECT_VERSION + 1)));
			$formatHistory = $this->formatHistory($history);
			
			// add news entry
			if ($this->newstext->getValue()) {
				$newsEntry = new DB_Record();
				$newsEntry->subject = 'Update';
				$newsEntry->text = $this->newstext->getValue();
				$newsEntry->time = time();
				Rakuun_DB_Containers_Persistent::getNewsContainer()->save($newsEntry);
			}
			if ($this->tweet->getValue()) {
				$object = new Twitter(RAKUUN_TWITTER_CONSUMERKEY, RAKUUN_TWITTER_CONSUMERSECRET, RAKUUN_TWITTER_ACCESSTOKEN, RAKUUN_TWITTER_ACCESSTOKENSECRET);
				$object->send($this->tweet->getValue());
			}
		}
		
		// update revision number
		$ssh->exec('chmod 666 www/Rakuun/config/revision.php');
		$file = PROJECT_PATH.'/config/revision.php';
		$file_contents = file_get_contents($file);
		
		$fh = fopen($file, 'w');
		$file_contents = preg_replace('=\(\'PROJECT_VERSION\', \d+\)=', '(\'PROJECT_VERSION\', '.$revisionNumber.')', $file_contents);
		fwrite($fh, $file_contents);
		fclose($fh);
		$ssh->exec('chmod 644 www/Rakuun/config/revision.php');
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
					$formatHistory .= '<strong>revision '.$revision.'</strong>:'."\n".'<ul>'.$revisionHistory.'</ul><br/>'."\n";
					$revision = -1;
					$revisionHistory = '';
					continue;
				}
				
				if ($historyEntry)
					$revisionHistory .= '<li>'.$historyEntry.'</li>'."\n";
			}
		}
		
		return $formatHistory;
	}
}

?>