<?php

class Rakuun_Intern_GUI_Panel_Reports_Filter extends GUI_Panel {
	const WHO_ATTER = 'user';
	const WHO_DEFFER = 'spied_user';
	const HOW_EQUAL = 'equal';
	const HOW_UNEQUAL = 'unequal';
	const HOW_GT_EQUAL = 'gt-equal';
	const HOW_LT_EQUAL = 'lt-equal';
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/filter.tpl');
		$this->addPanel($filterControl = new GUI_Control_DropDownBox('filter', array(self::WHO_ATTER => 'Angreifer', self::WHO_DEFFER => 'Ziel')));
		$filterControl->addClasses('filter');
		$this->addPanel(new GUI_Control_DropDownBox('how', array(self::HOW_EQUAL => '==', self::HOW_UNEQUAL => '!=')));
		$this->addPanel(new Rakuun_GUI_Control_UserSelect('what'));
		$filter = array();
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		foreach ($units as $unit) {
			$filter[$unit->getInternalName()] = $unit->getName();
		}
		$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
		foreach ($buildings as $building) {
			$filter[$building->getInternalName()] = $building->getName();
		}
		$this->addPanel($filter1Control = new GUI_Control_DropDownBox('filter1', $filter));
		$filter1Control->addClasses('filter1');
		$this->addPanel(new GUI_Control_DropDownBox('how1', array(self::HOW_LT_EQUAL => '<=', self::HOW_EQUAL => '==', self::HOW_GT_EQUAL => '>=', self::HOW_UNEQUAL => '!=')));
		$this->addPanel(new GUI_Control_TextBox('what1'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Filtern'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$this->getModule()->contentPanel->reportsbox->getContentPanel()->reports->setFilter(
			array(
				'filter' => $this->filter->getKey(),
				'how' => $this->how->getKey(),
				'what' => $this->what->getUser(),
				'filter1' => $this->filter1->getKey(),
				'how1' => $this->how1->getKey(),
				'what1' => $this->what1->getValue()
			)
		);
	}
	
	public static function getRelation($relation) {
		$relations = array(
			self::HOW_EQUAL => '=',
			self::HOW_UNEQUAL => '!=',
			self::HOW_GT_EQUAL => '>=',
			self::HOW_LT_EQUAL => '<='
		);
		return $relations[$relation];
	}
}
?>