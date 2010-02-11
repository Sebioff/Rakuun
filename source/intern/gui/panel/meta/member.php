<?php

class Rakuun_Intern_GUI_Panel_Meta_Member extends GUI_Panel {
	private $meta = null;
	
	public function __construct($name, Rakuun_DB_Meta $meta, $title = '') {
		$this->meta = $meta;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/member.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('member', 'Metamitglieder'));
		$table->addHeader(array('Allianz', 'Allianzleiter'));
		$options = array();
		$options['order'] = 'name ASC';
		foreach ($this->meta->alliances->select($options) as $alliance) {
			$leader = Rakuun_Intern_Alliance_Security::getForAlliance($alliance)->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
			$links = array();
			foreach ($leader as $user) {
				$link = new Rakuun_GUI_Control_UserLink('user'.$user->getPK(), $user);
				$links[] = $link->render();
			}
			$table->addLine(
				array(
					new Rakuun_GUI_Control_AllianceLink('alliance'.$alliance->getPK(), $alliance),
					implode(', ', $links)
				)
			);
		}
	}
}
?>