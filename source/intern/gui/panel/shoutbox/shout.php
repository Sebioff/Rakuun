<?php

/**
 * Class to display a single shout.
 */
class Rakuun_Intern_GUI_Panel_Shoutbox_Shout extends GUI_Panel {
	private $shout = null;
	
	public function __construct($name, DB_Record $shout, $title = '') {
		$this->shout = $shout;
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/shout.tpl');
		$this->params->shout = $this->shout;
		$this->addPanel(new GUI_Panel_Date('date', $this->shout->date));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('userlink', $this->shout->user, $this->shout->get('user')));
		if ($this->shout->user) {
			$params['answerid'] = $this->shout->user->getPK();
			$params[$this->getParent()->getName().'-page'] = $this->getParent()->getPage();
			$this->addPanel(new GUI_Control_JsLink('answerlink', '-antworten-', '$(\'#'.$this->getParent()->shoutarea->getID().'\').val(\'@'.$this->shout->user->nameUncolored.': \').focus(); return false;', Router::get()->getCurrentModule()->getUrl($params)));
		}
	}
}

?>