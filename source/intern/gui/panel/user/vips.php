<?php

/**
 * shows all important Persons in this Game
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_User_VIPs extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/vips.tpl');
		
		//traverse all Groups
		$i = 0;
		foreach (Rakuun_GameSecurity::get()->getVIPGroups() as $group) {
			$table = new GUI_Panel_Table('group_'.$i);
			$header = array();
			$header[] = $group->name;
			if ($group->id == Rakuun_GameSecurity::GROUP_TEAM)
				$header[] = 'Aufgaben';
			$table->addHeader($header);
			
			//traverse all users in this group
			$users = array();
			$j = 0;
			foreach (Rakuun_GameSecurity::get()->getGroupUsers($group) as $user) {
				$line = array();
				$userlink = new Rakuun_GUI_Control_Userlink('userlink_'.$i * $j + $j, $user);
				$line[] = $userlink;
				if ($group->id == Rakuun_GameSecurity::GROUP_TEAM) {
					$privileges = array();
					foreach (Rakuun_TeamSecurity::get()->getUserGroups($user) as $teamgroup) {
						$privileges[] = $teamgroup->name;
					}
					$line[] = implode(', ', $privileges);
				}
				$table->addLine($line);
				++$j;
			}
			$this->addPanel($table);
			++$i;
		}
	}
}

?>