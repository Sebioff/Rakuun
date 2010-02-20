<?php

class Rakuun_Intern_GUI_Panel_Map_DefendingUnits_Item extends GUI_Panel {
	private $unit = null;
	
	public function __construct($name, Rakuun_Intern_Production_Unit $unit) {
		parent::__construct($name);
		$this->unit = $unit;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/item.tpl');
		$this->addPanel(new GUI_Panel_Text('value_panel', $this->unit->getNameForAmount(2) .' ('.GUI_Panel_Number::formatNumber($this->unit->getAmount()).')'));
		$this->addPanel(new GUI_Control_SubmitButton('move_up', '^'));
		$this->addPanel(new GUI_Control_SubmitButton('move_down', 'v'));
	}
	
	public function onMoveUp() {
		$fightingSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->fightingSequence);
		$position = array_search($this->unit->getInternalName(), $fightingSequence);
		if ($position < count($fightingSequence) - 1) {
			$temp = $fightingSequence[$position];
			$fightingSequence[$position] = $fightingSequence[$position + 1];
			$fightingSequence[$position + 1] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->fightingSequence = implode('|', $fightingSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
	
	public function onMoveDown() {
		$fightingSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->fightingSequence);
		$position = array_search($this->unit->getInternalName(), $fightingSequence);
		if ($position > 0) {
			$temp = $fightingSequence[$position];
			$fightingSequence[$position] = $fightingSequence[$position - 1];
			$fightingSequence[$position - 1] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->fightingSequence = implode('|', $fightingSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
}

?>