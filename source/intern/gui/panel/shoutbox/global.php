<?php

class Rakuun_Intern_GUI_Panel_Shoutbox_Global extends Rakuun_Intern_GUI_Panel_Shoutbox {
	public function __construct($name, $title = '') {
		$this->config = new Shoutbox_Config();
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->config->setShoutContainer(Rakuun_DB_Containers::getShoutboxContainer());
		$shout = new DB_Record();
		$shout->user = $user;
		$this->config->setShoutRecord($shout);
		$this->config->setShoutMaxLength(250);
		$this->config->setDeleteQuery('
			DELETE FROM '.$this->config->getShoutContainer()->getTable().'
			WHERE ID <= (
				SELECT MIN(ID) 
				FROM (
					SELECT ID 
					FROM '.$this->config->getShoutContainer()->getTable().'
					ORDER BY date DESC 
					LIMIT 1
					OFFSET 100
				) as temp
			)
		');
		$this->config->setUserIsMod(Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_MODERATION));
		$this->config->setIsGlobal(true);
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($user->shoutboxTimeban > 0 && $user->shoutboxTimeban < time()) {
			// delete user's timeban
			$user->shoutboxTimeban = 0;
			$user->save();			
		}
	}
	
	public function onSubmit() {
		if ($this->config->getIsGlobal() &&	Rakuun_User_Manager::getCurrentUser()->shoutboxTimeban > 0)
			$this->addError('Du bist noch für '.Rakuun_Date::formatCountDown((Rakuun_User_Manager::getCurrentUser()->shoutboxTimeban) - time()).' aus dieser Shoutbox gebannt!');
			
		parent::onSubmit();
	}
}
?>