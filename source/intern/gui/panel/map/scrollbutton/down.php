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

class Rakuun_Intern_GUI_Panel_Map_ScrollButton_Down extends Rakuun_Intern_GUI_Panel_Map_ScrollButton {
	public function init() {
		parent::init();
		
		$this->setScrollDeltaY(3);
		$this->setAttribute('style', '
			background:#555555 url(\''.Router::get()->getStaticRoute('images', 'tech/map_scroll_down.gif').'\') no-repeat center top;
			cursor:pointer;
			display:block;
			height:13px;
			width:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE + 26).'px;
			text-align:center;
		');
	}
}

?>