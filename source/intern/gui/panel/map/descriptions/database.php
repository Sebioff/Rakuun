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

class Rakuun_Intern_GUI_Panel_Map_Descriptions_Database extends GUI_Panel_HoverInfo {
	private $databaseIdentifier = 0;
	private $positionX = 0;
	private $positionY = 0;
	private $map = null;
	
	public function __construct(Rakuun_Intern_GUI_Panel_Map $map, $databaseIdentifier, $positionX, $positionY) {
		parent::__construct('db'.$databaseIdentifier, '', '');
		
		$this->map = $map;
		$this->databaseIdentifier = $databaseIdentifier;
		$this->positionX = $positionX;
		$this->positionY = $positionY;

		$this->setHoverText('Datenbank');
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/database.tpl');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$x = $this->positionX * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE;
		$y = $this->positionY * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE;
		$this->setAttribute('coords', $x.','.$y.','.($x + 10).','.($y + 10));
		$this->addJS(sprintf('
			$("#%s").click(function(event) {
				$(\'#%s\').val(\'%s\');
				$(\'#%s\').val(\'%s\');
				$(\'#%s\').val(\'\');
				return false;
			});
		', $this->getID(), $this->map->target->target->targetX->getID(), $this->positionX, $this->map->target->target->targetY->getID(), $this->positionY, $this->map->target->target->target->getID()));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getPositionX() {
		return $this->positionX;
	}
	
	public function getPositionY() {
		return $this->positionY;
	}
}

?>