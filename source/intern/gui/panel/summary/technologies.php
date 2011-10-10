<?php

class Rakuun_Intern_GUI_Panel_Summary_Technologies extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/summary.tpl');
		
		$table = new GUI_Panel_Table('summary');
		$summe = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if ($technology->getLevel() > 0) {
				$table->addLine(
					array(
						new GUI_Control_Link('link'.$technology->getInternalName(), $technology->getName(), App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $technology->getType(), 'id' => $technology->getInternalName()))),
						Text::formatNumber($technology->getLevel()),
						Text::formatNumber($technology->getLevel() * $technology->getPoints())
					)
				);
				$summe += $technology->getLevel() * $technology->getPoints();
			}
		}
		if (count($table->getLines()) == 0)
			$this->addPanel(new GUI_Panel_Text('summary', 'Keine.'));
		else {
			$table->addHeader(array('Name', 'Level', 'Punkte'));
			$table->addFooter(array('Summe:', '', Text::formatNumber($summe)));
			$this->addPanel($table);
		}
		$table->addTableCssClass('align_left', 0);
	}
}
?>