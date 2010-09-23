<?php

class Rakuun_Intern_GUI_Panel_Alliance_Ranks_View extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/view.tpl');
	}
	
	public function beforeDisplay() {
		parent::beforeDisplay();
		
		$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		$groupsContainer = Rakuun_Intern_Alliance_Security::get()->getContainerGroups();
		$groups = $groupsContainer->selectByAlliance($alliance, array('order' => 'name ASC'));
		
		foreach ($groups as $group) {
			if ($group->groupIdentifier == Rakuun_Intern_Alliance_Security::GROUP_LEADERS
				&& !Rakuun_Intern_Alliance_Security::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::GROUP_LEADERS)
			)
				continue;
			
			$url = Router::get()->getCurrentModule()->getUrl(array('rank' => $group->getPK()));
			$this->addPanel(new GUI_Control_Link('group_'.$group->getPK(), Text::escapeHTML($group->name), $url));
		}
		
		if (!$groups)
			$this->addPanel(new GUI_Panel_Text('none', 'Keine Ränge vorhanden.'));
	}
}

?>