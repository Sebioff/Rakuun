<?php

/**
 * Adds a new board to board.
 */
class Rakuun_Intern_GUI_Panel_Board_Addboard extends GUI_Panel {
	private $boardtype = null;
	public function __construct($name, $type) {
		$this->boardtype = $type;
		parent::__construct($name);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/addboard.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Boardname'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new GUI_Validator_RangeLength(2, 25));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'anlegen'));
	}
	
	public function onSubmit() {
		$board = new DB_Record();
		switch ($this->boardtype) {
			case Rakuun_Intern_GUI_Panel_Board_Boardview::TYPE_ALLIANCE:
				$board->alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
			break;
			case Rakuun_Intern_GUI_Panel_Board_Boardview::TYPE_META:
				$board->meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
			break;
			case Rakuun_Intern_GUI_Panel_Board_Boardview::TYPE_ADMIN:
				//do nothing
			break;
			default:
				$this->addError('Ubekannter Boardtype: '.$this->boardtype);
				return;
			break;
		}
		$board->name = $this->name;
		$board->type = $this->boardtype;
		Rakuun_DB_Containers::getBoardsContainer()->save($board);
	}
}

?>