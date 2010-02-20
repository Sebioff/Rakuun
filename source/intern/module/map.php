<?php

class Rakuun_Intern_Module_Map extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Karte');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/map.tpl');
		$paramUser = $this->getParam('user');
		$target = Rakuun_DB_Containers::getUserContainer()->selectByPK($paramUser);
		$paramX = $this->getParam('cityX');
		$paramY = $this->getParam('cityY');
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Map('map', $target, $paramX, $paramY));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('databasesbox', new Rakuun_Intern_GUI_Panel_Map_Databases('databases'), 'Datenbanken'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('units', new Rakuun_Intern_GUI_Panel_Map_DefendingUnits('units'), 'Einheiten'));
	}
}
		
?>