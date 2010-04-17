<?php

class Rakuun_Index_Panel_News_Item extends Rakuun_GUI_Panel_Box {
	public function __construct(DB_Record $record) {
		parent::__construct($record->getPK(), new Rakuun_Index_Panel_News_Item_Content($record, $this), $record->subject);
	}
	
	public function init() {
		parent::init();
		
		$this->addClasses('rakuun_news_item');
	}
}

class Rakuun_Index_Panel_News_Item_Content extends Rakuun_GUI_Panel_Box_Content {
	private $record = null;
	
	public function __construct(DB_Record $record, Rakuun_Index_Panel_News_Item $parent) {
		parent::__construct($parent->getName().'_content', $parent);
		
		$this->record = $record;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/item.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->getRecord()->time, 'Datum'));
		$this->addPanel(new GUI_Panel_Text('writer', $this->getRecord()->writer, 'Author'));
		$text = preg_replace('/#(\d+)\b/i', '<a href="http://tickets.rakuun.de/view.php?id=$1" target="_blank">$0</a>', $this->getRecord()->text);
		$text = Text::format($text);
		$this->addPanel(new GUI_Panel_Text('text', $text, 'Text'));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getRecord() {
		return $this->record;
	}
}

?>