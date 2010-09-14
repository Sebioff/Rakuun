<?php

/**
 * shows the active users who are still online.
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_User_Online extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/online.tpl');
		$this->addPanel($onlineusers = new GUI_Panel_Table('onlineusers'));
		$onlineusers->addHeader(array('Username', 'Allianz'));
		
		$options = array();
		$options['conditions'][] = array('is_online > ?', time() - Rakuun_Intern_Module::TIMEOUT_ISONLINE);
		$options['order'] = 'name ASC';
		$onlineUsers = Rakuun_DB_Containers::getUserContainer()->select($options);
		foreach ($onlineUsers as $user){
			$line = array();
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$user->getPK(), $user);
			if ($user->alliance) {
				$line[] = new Rakuun_GUI_Control_AllianceLink('alliance'.$user->getPK(), $user->alliance);
			} else {
				$line[] = '';
			}
			$onlineusers->addLine($line);
		}
		$this->params->onlineCount = count($onlineUsers);
	}
}

?>