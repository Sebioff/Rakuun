<?php

class Rakuun_Intern_GUI_Panel_Shoutbox_Meta extends Rakuun_Intern_GUI_Panel_Shoutbox {
	private $meta = null;
	
	public function __construct($name, $title = '') {
		$this->meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
		$options['conditions'][] = array('meta = ?', $this->meta);
		parent::__construct($name, Rakuun_DB_Containers::getShoutboxMetasContainer()->getFilteredContainer($options), $title);
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$shout = new DB_Record();
		$shout->meta = $this->meta;
		$shout->user = Rakuun_User_Manager::getCurrentUser();
		$shout->text = $this->shoutarea->getValue();
		$shout->date = time();
		$this->getContainer()->save($shout);
		$this->shoutarea->resetValue();
		
		// FIXME kinda wtf :/...only works with sub-sub-query
		$this->getContainer()->deleteByQuery('
			DELETE FROM '.$this->getContainer()->getTable().'
			WHERE ID <= (
				SELECT MIN(ID)
				FROM(
					SELECT ID
					FROM '.$this->getContainer()->getTable().'
					WHERE meta = '.$this->meta->getPK().'
					ORDER BY date DESC
					LIMIT 1
					OFFSET 100
				) as temp
			) AND meta = '.$this->meta->getPK().'
		');
	}
}
?>