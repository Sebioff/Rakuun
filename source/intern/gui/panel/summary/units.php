<?php

class Rakuun_Intern_GUI_Panel_Summary_Units extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/summary.tpl');
		
		$table = new GUI_Panel_Table('summary');
		$summeAtt = 0;
		$summeDeff = 0;
		$summeArmystrength = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->getAmount() > 0) {
				$table->addLine(
					array(
						new GUI_Control_Link('link'.$unit->getInternalName(), $unit->getName(), App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $unit->getType(), 'id' => $unit->getInternalName()))),
						GUI_Panel_Number::formatNumber($unit->getAmount()),
						GUI_Panel_Number::formatNumber($unit->getAttackValue()),
						GUI_Panel_Number::formatNumber($unit->getDefenseValue()),
						GUI_Panel_Number::formatNumber($unit->getArmyStrength())
					)
				);
				$summeAtt += $unit->getAttackValue();
				$summeDeff += $unit->getDefenseValue();
				$summeArmystrength += $unit->getArmyStrength();
			}
		}
		if (count($table->getLines()) == 0)
			$this->addPanel(new GUI_Panel_Text('summary', 'Keine.'));
		else {
			$table->addHeader(array('Name', 'Anzahl', 'Att', 'Deff', 'Armeestärke'));
			$table->addFooter(array('Summe:', '', GUI_Panel_Number::formatNumber($summeAtt), GUI_Panel_Number::formatNumber($summeDeff), GUI_Panel_Number::formatNumber($summeArmystrength)));
			$wall = Rakuun_Intern_Production_Factory::getBuilding('city_wall');
			if ($wall->getLevel() > 0)
				$table->addFooter(array('Summe ohne Mauer:', '', '', GUI_Panel_Number::formatNumber($summeDeff - ($summeDeff / (1 + (100 / ($wall->getLevel() * Rakuun_Intern_Production_Building_CityWall::DEFENSE_BONUS_PERCENT))))), ''));
			$this->addPanel($table);
		}
		$table->addTableCssClass('align_left', 0);
	}
}
?>