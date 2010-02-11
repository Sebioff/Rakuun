<?php

class Rakuun_Intern_Module_Messages extends Rakuun_Intern_Module {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->addSubmodule(new Rakuun_Intern_Module_Messages_Display('display'));
	}
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Nachrichten');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/messages.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('directory', new Rakuun_Intern_GUI_Panel_User_Directory('directory', Rakuun_Intern_GUI_Panel_User_Directory::TYPE_MESSAGES), 'Adressbuch'));
		$param = $this->getParam('user');
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
		if (!($messageType = $this->getParam('category')))
			$messageType = Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_UNREAD;
		if ($messageType == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS)
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('send', new Rakuun_Intern_GUI_Panel_Message_Support('support'), 'Support anschreiben'));
		else
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('send', new Rakuun_Intern_GUI_Panel_Message_Send('send', '', null, $user), 'Nachricht schicken'));
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message_View('view', $messageType));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message_Categories('categories', 'Nachrichtenkategorien'));
	}
}

?>