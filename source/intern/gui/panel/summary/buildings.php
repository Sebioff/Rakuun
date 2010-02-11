<?php

class Rakuun_Intern_GUI_Panel_Summary_Buildings extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/summary.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('summary'));
		$summe = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			if ($building->getLevel() > 0) {
				$table->addLine(
					array(
						new GUI_Control_Link('link'.$building->getInternalName(), $building->getName(), App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $building->getType(), 'id' => $building->getInternalName()))),
						GUI_Panel_Number::formatNumber($building->getLevel()),
						GUI_Panel_Number::formatNumber($building->getLevel() * $building->getPoints())
					)
				);
				$summe += $building->getLevel() * $building->getPoints();
			}
		}
		$table->addHeader(array('Name', 'Level', 'Punkte'));
		$table->addFooter(array('Summe:', '', GUI_Panel_Number::formatNumber($summe)));
	}
}
?>