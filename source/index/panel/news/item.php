<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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