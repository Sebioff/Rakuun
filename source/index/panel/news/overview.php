<?php

class Rakuun_Index_Panel_News_Overview extends GUI_Panel_PageView {
	public function __construct($name, $title = '') {
		parent::__construct($name, Rakuun_DB_Containers_Persistent::getNewsContainer(), $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/overview.tpl');
		$this->setItemsPerPage(5);
		
		$news = array();
		$options = $this->getOptions();
		$options['order'] = 'time DESC';
		foreach ($this->getContainer()->select($options) as $newsEntry) {
			$this->addPanel($newsPanel = new Rakuun_Index_Panel_News_Item($newsEntry));
			$news[] = $newsPanel;
		}
		$this->params->news = $news;
	}
}

?>