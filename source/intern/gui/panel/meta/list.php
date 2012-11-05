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

class Rakuun_Intern_GUI_Panel_Meta_List extends GUI_Panel {
	private $meta = null;
	
	public function __construct($name, DB_Record $meta, $title = '') {
		parent::__construct($name, $title);
		
		$this->meta = $meta;
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel($list = new GUI_Panel_List('list'));
		$options = array();
		$options['order'] = 'name ASC';
		foreach ($this->meta->alliances->select($options) as $alliance) {
			$link = new Rakuun_GUI_Control_AllianceLink('link'.$alliance->getPK(), $alliance);
			$list->addItem($link);
		}
	}
}
?>