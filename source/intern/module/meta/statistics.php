<?php

class Rakuun_Intern_Module_Meta_Statistics extends Rakuun_Intern_Module_Meta_Navigation {
	public function init() {
		parent::init();

		$meta = $this->getUser()->alliance->meta;
		$this->setPageTitle('Statistiken - '.$meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/statistics.tpl');
		$options['order'] = 'name ASC';
		$alliances = Rakuun_User_Manager::getCurrentUser()->alliance->meta->alliances->select($options);
		$panels = array();
		foreach ($alliances as $alliance) {
			$ressourcesPanel = new Rakuun_GUI_Panel_Box('ressources-'.$alliance->getPK(), new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Ressources('ressources', $alliance), 'Rohstoffübersicht');
			$this->contentPanel->addPanel($ressourcesPanel);
			$armyPanel = new Rakuun_GUI_Panel_Box('army-'.$alliance->getPK(), new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Army('army', $alliance), 'Armeeübersicht');
			$this->contentPanel->addPanel($armyPanel);
			$panels[] = array(
				'alliancelink' => new Rakuun_GUI_Control_AllianceLink('link-'.$alliance->getPK(), $alliance),
				'ressources' => $ressourcesPanel,
				'army' => $armyPanel
			);
		}
		$this->contentPanel->params->panels = $panels;
	}
}

?>