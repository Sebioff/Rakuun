<?php

/**
 * Displays a directory, usable for messages and army purposes atm
 */
class Rakuun_Intern_GUI_Panel_User_Directory extends GUI_Panel {
	const TYPE_MESSAGES = 1;
	const TYPE_ARMY = 2;
	
	private $groupContainer = null;
	private $assocContainer = null;
	private $type = self::TYPE_MESSAGES;
	
	public function __construct($name, $type, $title = '') {
		$this->type = $type;
		switch ($type) {
			case self::TYPE_ARMY:
				$this->groupContainer = Rakuun_DB_Containers::getUsersDirectoryArmyGroupsContainer();
				$this->assocContainer = Rakuun_DB_Containers::getUsersDirectoryArmyGroupsAssocContainer();
			break;
			case self::TYPE_MESSAGES:
				$this->groupContainer = Rakuun_DB_Containers::getUsersDirectoryMessagesGroupsContainer();
				$this->assocContainer = Rakuun_DB_Containers::getUsersDirectoryMessagesGroupsAssocContainer();
			break;
			default:
				throw new Core_Exception('Unknown Directory Type: '.$type);
			break;
		}
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		if ($this->getModule()->getParam('edit') == true) {
			$this->addPanel(new Rakuun_Intern_GUI_Panel_User_Directory_Edit('edit', $this->groupContainer, $this->assocContainer));
			return;
		}
		
		$this->setTemplate(dirname(__FILE__).'/directory.tpl');
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$groups = $this->groupContainer->select($options);
		$_groups = array();
		foreach ($groups as $group) {
			$_groups[] = array(
				'group' => $group,
				'entities' => $this->assocContainer->selectByGroup($group)
			);
		}
		$this->params->groups = $_groups;
		$this->params->type = $this->type;
		
		$this->addPanel($text = new Rakuun_GUI_Control_UserSelect('name'));
		$text->setTitle('Name');
		$text->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
	}
	
	public function onSubmit() {
		if ($this->name->getUser() && $this->name->getUser()->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK())
			$this->addError('Du kannst dich nicht selbst zum Adressbuch hinzufügen.');
	
		if ($this->hasErrors())
			return;
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('name = ?', 'default');
		$group = $this->groupContainer->selectFirst($options);
		if (!$group) {
			// create default-group if no one exists yet
			$group = new DB_Record();
			$group->user = Rakuun_User_Manager::getCurrentUser();
			$group->name = 'default';
			$this->groupContainer->save($group);
		}
		$assoc = new DB_Record();
		$assoc->group = $group;
		$assoc->user = $this->name->getUser();
		$options = array();
		$assocTable = $this->assocContainer->getTable();
		$groupTable = $this->groupContainer->getTable();
		$options['join'] = array($groupTable);
		$options['conditions'][] = array($groupTable.'.`user` = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array($groupTable.'.`id` = '.$assocTable.'.`group`');
		$options['conditions'][] = array($assocTable.'.`user` = ?', $this->name->getUser());
		// only add if user isn't in a group yet
		if ($assoc->user && !$this->assocContainer->selectFirst($options))
			$this->assocContainer->save($assoc);
			
		$this->getModule()->invalidate();
	}
}
?>