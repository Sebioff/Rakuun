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