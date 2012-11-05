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
 * Display a shoutbox.
 */
abstract class Rakuun_Intern_GUI_Panel_Shoutbox extends GUI_Panel_PageView {
	const ANNOUNCER_USERID = 0;
	
	protected $config = null;
	
	public function __construct($name, $title = '') {
		$this->setItemsPerPage(10);
		
		$options['order'] = 'date DESC';
		parent::__construct($name, $this->config->getShoutContainer()->getFilteredContainer($options), $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/shoutbox.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addPanel(new GUI_Control_Link('refresh', 'Aktualisieren', $this->getModule()->getUrl()));
		if ($this->config->getUserIsMod())
			$this->addPanel(new GUI_Control_Link('moderatelink', 'Moderieren', $this->getModule()->getUrl(array('moderate' => $user->getPK()))));
		$this->addPanel($text = new GUI_Control_TextArea('shoutarea', '', 'Text'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$text->addValidator(new GUI_Validator_Maxlength($this->config->getShoutMaxLength()));
		if (Router::get()->getCurrentModule()->getParam('answerid') > 0) {
			$answerUser = Rakuun_DB_Containers::getUserContainer()->selectByIdFirst(Router::get()->getCurrentModule()->getParam('answerid'));
			if ($answerUser)
				$text->setValue('@@'.$answerUser->nameUncolored.'@: ');
			$text->setFocus();
		}
		$this->addPanel(new GUI_Control_AjaxSubmitButton('submit', 'shout!'));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Shoutbox_Info('info', $text, 'Codes'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$shouts = $this->getContainer()->select($this->getOptions());
		foreach ($shouts as $shout) {
			$this->addPanel(new Rakuun_Intern_GUI_Panel_Shoutbox_Shout('shout_'.$shout->getPK(), $this->config, $shout));
		}
		
		$this->refresh->setAttribute('onclick', sprintf('$(\'#%1$s\').addClass(\'core_ajax_loading\'); $.core.refreshPanels([\'%2$s\']); return false;', $this->getID(), $this->getParent()->getID()));
		
		$this->shoutarea->addJS(sprintf(
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
			$this->shoutarea->getID(), $this->config->getShoutMaxLength()
		));
	}
	
	public function onSubmit() {
		if (Rakuun_GameSecurity::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_GameSecurity::GROUP_DEMO)) {
			$this->addError('Anonym darf nicht geshouted werden ;)');
		}
		
		if ($this->hasErrors())
			return;
			
		$shout = $this->config->getShoutRecord();
		$shout->text = $this->shoutarea->getValue();
		$shout->date = time();
		$this->config->getShoutContainer()->save($shout);
		$this->shoutarea->resetValue();
		
		// kinda wtf :/...only works with sub-sub-query
		$this->config->getShoutContainer()->deleteByQuery($this->config->getDeleteQuery());
	}
}

class Shoutbox_Config {
	private $shoutContainer = null;
	private $shoutRecord = null;
	private $shoutMaxLength = 0;
	private $deleteQuery = '';
	private $userIsMod = false;
	private $isGlobal = false;
	
	public function getShoutContainer() {
		return $this->shoutContainer;
	}
	
	public function setShoutContainer(DB_Container $container) {
		$this->shoutContainer = $container;
	}
	
	public function getShoutRecord() {
		return $this->shoutRecord;
	}
	
	public function setShoutRecord(DB_Record $record) {
		$this->shoutRecord = $record;
	}
	
	public function getShoutMaxLength() {
		return $this->shoutMaxLength;
	}
	
	public function setShoutMaxLength($maxLength) {
		$this->shoutMaxLength = (int)$maxLength;
	}
	
	public function getDeleteQuery() {
		return $this->deleteQuery;
	}
	
	public function setDeleteQuery($query) {
		$this->deleteQuery = (string)$query;
	}
	
	public function getUserIsMod() {
		return $this->userIsMod;
	}
	
	public function setUserIsMod($mod) {
		$this->userIsMod = (bool)$mod;
	}
	
	public function getIsGlobal() {
		return $this->isGlobal;
	}
	
	public function setIsGlobal($global) {
		$this->isGlobal = (bool)$global;
	}
}
?>