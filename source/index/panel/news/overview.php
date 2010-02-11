<?php

class Rakuun_Index_Panel_News_Overview extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/overview.tpl');
		
		$news = array();
		$options = array();
		$options['order'] = 'time DESC';
		foreach (Rakuun_DB_Containers::getNewsContainer()->select($options) as $newsEntry) {
			$this->addPanel($newsPanel = new Rakuun_Index_Panel_News_Item($newsEntry));
			$news[] = $newsPanel;
		}
		$this->params->news = $news;
	}
}

?>