<?php

class Rakuun_Intern_GUI_Panel_Shoutbox_Alliance extends Rakuun_Intern_GUI_Panel_Shoutbox {
	private $alliance = null;
	
	public function __construct($name, Rakuun_DB_Alliance $alliance = null, $title = '') {
		$this->alliance = $alliance === null ? Rakuun_User_Manager::getCurrentUser()->alliance : $alliance;
		$options['conditions'][] = array('alliance = ?', $this->alliance);
		parent::__construct($name, Rakuun_DB_Containers::getShoutboxAlliancesContainer()->getFilteredContainer($options), $title);
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$shout = new DB_Record();
		$shout->alliance = $this->alliance;
		$shout->user = Rakuun_User_Manager::getCurrentUser();
		$shout->text = $this->shoutarea->getValue();
		$shout->date = time();
		$this->getContainer()->save($shout);
		$this->shoutarea->resetValue();
		
		// kinda wtf :/...only works with sub-sub-query
		$this->getContainer()->deleteByQuery('
			DELETE FROM '.$this->getContainer()->getTable().'
			WHERE ID <= (
				SELECT MIN(ID)
				FROM(
					SELECT ID
					FROM '.$this->getContainer()->getTable().'
					WHERE alliance = '.$this->alliance->getPK().'
					ORDER BY date DESC
					LIMIT 1
					OFFSET 100
				) as temp
			) AND alliance = '.$this->alliance->getPK().'
		');
	}
}
?>