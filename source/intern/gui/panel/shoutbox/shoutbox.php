<?php

/**
 * Display a shoutbox.
 */
class Rakuun_Intern_GUI_Panel_Shoutbox extends GUI_Panel_PageView {
	const SHOUT_MAX_LENGTH = 250;
	
	public function __construct($name, $title = '') {
		$this->setItemsPerPage(10);
		$options['order'] = 'date DESC';
		parent::__construct($name, Rakuun_DB_Containers::getShoutboxContainer()->getFilteredContainer($options), $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/shoutbox.tpl');
		$this->addPanel($text = new GUI_Control_TextArea('shoutarea', '', 'Text'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$text->addValidator(new GUI_Validator_Maxlength(self::SHOUT_MAX_LENGTH));
		if (Router::get()->getCurrentModule()->getParam('answerid') > 0) {
			$user = Rakuun_DB_Containers::getUserContainer()->selectByIdFirst(Router::get()->getCurrentModule()->getParam('answerid'));
			$text->setValue('@'.$user->nameUncolored.': ');
			$text->setFocus();
		}
		$this->addPanel(new GUI_Control_Link('refresh', 'Aktualisieren', $this->getModule()->getUrl()));
		$this->addPanel(new GUI_Control_AjaxSubmitButton('submit', 'shout!'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$shouts = $this->getContainer()->select($this->getOptions());
		foreach ($shouts as $shout) {
			$this->addPanel(new Rakuun_Intern_GUI_Panel_Shoutbox_Shout('shout_'.$shout->getPK(), $shout));
		}
		
		$this->refresh->setAttribute('onclick', sprintf('$.core.refreshPanels([\'%s\']); return false;', $this->getParent()->getID()));
		
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
			$this->shoutarea->getID(), self::SHOUT_MAX_LENGTH
		));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$shout = new DB_Record();
		$shout->user = Rakuun_User_Manager::getCurrentUser();
		$shout->text = $this->shoutarea->getValue();
		$shout->date = time();
		Rakuun_DB_Containers::getShoutboxContainer()->save($shout);
		$this->shoutarea->resetValue();
		
		// kinda wtf :/...only works with sub-sub-query
		$this->getContainer()->deleteByQuery('DELETE FROM '.$this->getContainer()->getTable().' WHERE ID <= (SELECT MIN(ID) FROM(SELECT ID FROM '.$this->getContainer()->getTable().' ORDER BY date DESC LIMIT 1 OFFSET 100) as temp)');
	}
}

?>