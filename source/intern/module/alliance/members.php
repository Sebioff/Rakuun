<?php

class Rakuun_Intern_Module_Alliance_Members extends Rakuun_Intern_Module_Alliance_Navigation implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$alliance = $this->getUser()->alliance;
		$this->setPageTitle('Mitglieder - ['.$alliance->tag.'] '.$alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/members.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('member', new Rakuun_Intern_GUI_Panel_Alliance_Members('member', $alliance), 'Mitglieder von "'.Text::escapeHTML($alliance->name).'"'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}

?>