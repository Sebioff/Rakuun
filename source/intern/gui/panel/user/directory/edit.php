<?php

/**
 * Displays a panel to add and change directory groups.
 */
class Rakuun_Intern_GUI_Panel_User_Directory_Edit extends GUI_Panel {
	private $groupContainer = null;
	private $assocContainer = null;
	
	public function __construct($name, DB_Container $groupContainer, DB_Container $assocContainer, $title = '') {;
		$this->groupContainer = $groupContainer;
		$this->assocContainer = $assocContainer;
				
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/edit.tpl');
		$this->addPanel(new GUI_Control_SubmitButton('safe', 'Speichern'));
		$this->addPanel($groupname = new GUI_Control_TextBox('groupname'));
		$groupname->setTitle('Gruppenname');
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Hinzufügen'));
		$options = array();
		$options['conditions'][] = array('`user` = ?', Rakuun_User_Manager::getCurrentUser());
		$options['order'] = 'name ASC';
		$groups = $this->groupContainer->select($options);
		$_groups = array();
		$_assocs = array();
		//load all groups from actual user
		foreach ($groups as $group) {
			//find all users belonging to user's groups
			$assocs = $this->assocContainer->selectByGroup($group);
			$_groups[$group->getPK()] = $group->name;
			foreach ($assocs as $assoc) {
				$assoc->group = $group;
				$_assocs[] = $assoc;
			}
		}
		$lists = array();
		//create dropdown lists for each directory entity with current and other groups
		foreach ($_assocs as $_assoc) {
			$this->addPanel(
				$list = new GUI_Control_DropDownBox(
					'list'.$_assoc->getPK(),
					$_groups,
					$_assoc->group->getPK()
				)
			);
			$lists[] = array(
				'list' => $list,
				'assoc' => $_assoc
			);
		}
		$this->params->lists = $lists;
	}
	
	// safe a new group
	public function onSubmit() {
		if (!$this->groupname->getValue())
			return;
		
		$options = array();
		$options['conditions'][] = array('`user` = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('`name` = ?', $this->groupname->getValue());
		$group = $this->groupContainer->select($options);		if ($group) {
			$this->addError('Eine Gruppe mit diesem Namen besteht bereits.');
			return;
		}
		$group = new DB_Record();
		$group->user = Rakuun_User_Manager::getCurrentUser();
		$group->name = $this->groupname->getValue();
		$this->groupContainer->save($group);
	}
	
	// update entity's groups
	public function onSafe() {
		foreach ($this->params->lists as $list) {
			$name = $list['list']->getName();
			preg_match('=^list(\d+)$=Ui', $name, $matches);
			$assoc = $this->assocContainer->selectByIdFirst($matches[1]);
			$assoc->group = $this->$name->getKey();
			$this->assocContainer->save($assoc);
		}
	}
}

?>