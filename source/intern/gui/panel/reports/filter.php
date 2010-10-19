<?php

class Rakuun_Intern_GUI_Panel_Reports_Filter extends GUI_Panel {
	const WHO_ATTER = 'atter';
	const WHO_DEFFER = 'deffer';
	const HOW_EQUAL = 'equal';
	const HOW_UNEQUAL = 'unequal';
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_DropDownBox('who', array(self::WHO_ATTER => 'Angreifer', self::WHO_DEFFER => 'Ziel')));
		$this->addPanel(new GUI_Control_DropDownBox('how', array(self::HOW_EQUAL => '==', self::HOW_UNEQUAL => '!=')));
		$this->addPanel(new Rakuun_GUI_Control_UserSelect('what'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Filtern'));
	}
	
	public function onSubmit() {
		$this->getModule()->contentPanel->reportsbox->getContentPanel()->reports->setFilter(
			array(
				'who' => $this->who->getKey(),
				'how' => $this->how->getKey(),
				'what' => $this->what->getUser()
			)
		);
	}
}
?>