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

class Rakuun_Intern_GUI_Panel_Map extends GUI_Panel {
	const MAP_WIDTH = 125;
	const MAP_HEIGHT = 125;
	const MAP_RECT_SIZE = 10;

	private $zoom = 1;
	private $viewRectSize = 45;
	private $viewRectX = 0;
	private $viewRectY = 0;
	private $targetUser = null;
	private $cityX = 0;
	private $cityY = 0;
	
	public function __construct($name, Rakuun_DB_User $targetUser = null, $cityX = 0, $cityY = 0) {
		parent::__construct($name);
		
		$this->setTarget($cityX, $cityY, $targetUser);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/map.tpl');
		
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_Path('path', $this));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_Items('items', $this));
		$this->addPanel(new Rakuun_GUI_Panel_Box('target', $target = new Rakuun_Intern_GUI_Panel_Map_Target('target', $this->targetUser, $this->cityX, $this->cityY), 'Zielauswahl'));
		$this->setTarget($target->targetX->getValue(), $target->targetY->getValue(), $target->target->getUser());
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_ScrollButton_Left('scroll_left', '', $this));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_ScrollButton_Right('scroll_right', '', $this));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_ScrollButton_Up('scroll_up', '', $this));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_ScrollButton_Down('scroll_down', '', $this));
		$this->addPanel(new Rakuun_GUI_Panel_Box('legend', new Rakuun_Intern_GUI_Panel_Map_Legend('legend'), 'Legende'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('directorylast', new Rakuun_Intern_GUI_Panel_Map_Directory_Last('directory'), 'Letzte 10 Angriffe'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('directorytop', new Rakuun_Intern_GUI_Panel_Map_Directory_Top('directory'), 'Top 10 Angriffe'));
		
		$this->addClasses('rakuun_map');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'cursor:move',
			'overflow:scroll',	// for disabled JS
			'position:relative',
			'float:left',
			'height:'.$this->viewRectSize * self::MAP_RECT_SIZE.'px',
			'width:'.$this->viewRectSize * self::MAP_RECT_SIZE.'px'
		);
		$this->setAttribute('style', implode(';', $style));
		
		/*
		 * TODO meh, IE knows only background-position-x/y instead of background-position...
		 * (only for reading, writing works perfectly!)
		 * check if background-position works with jquery 1.4
		 */
		$this->addJS(
			sprintf('
				function bgX(element) {
					if($.browser.msie)
						return parseInt($(element).css("background-position-x"));
					else
						return parseInt($(element).css("background-position").split(" ")[0]);
				}
				
				function bgY(element) {
					if($.browser.msie)
						return parseInt($(element).css("background-position-y"));
					else
						return parseInt($(element).css("background-position").split(" ")[1]);
				}
				
				function scroll(dx, dy) {
					globalX -= dx;
					globalY -= dy;
					if (globalX > 0) {
						dx = dx + globalX;
						globalX = 0;
					}
					if (globalX < -%4$d) {
						dx = dx + globalX + %4$d;
						globalX = -%4$d;
					}
					if (globalY > 0) {
						dy = dy + globalY;
						globalY = 0;
					}
					if (globalY < -%3$d) {
						dy = dy + globalY + %3$d;
						globalY = -%3$d;
					}
				
					$(".scroll_bg").each(function() {
						x = bgX(this);
						y = bgY(this);
						x -= dx;
						y -= dy;
						$(this).css("background-position", x + "px " + y + "px");
					});
					$("#rakuun_map_scroll_items, #rakuun_map_map_layer, #rakuun_map_indicator").each(function() {
						x = parseInt($(this).css("left"));
						y = parseInt($(this).css("top"));
						x -= dx;
						y -= dy;
						x = $(this).css("left", x + "px");
						y = $(this).css("top", y + "px");
					});
				}
				
				$("#%1$s")
				.css("overflow", "hidden")
				.mousedown(function(e) {
					pan = true;
					oldPageX = e.pageX;
					oldPageY = e.pageY;
					return false;
				}).mousemove(function(e) {
					e.preventDefault();
				}).click(function(e) {
					position = $(this).position();
					clickX = Math.floor((e.pageX - position.left - globalX) / MAP_RECT_SIZE);
					clickY = Math.floor((e.pageY - position.top - globalY) / MAP_RECT_SIZE);
					$("#'.$this->target->target->targetX->getID().'").val(clickX);
					$("#'.$this->target->target->targetY->getID().'").val(clickY);
					$("#'.$this->target->target->target->getID().'").val("");
				});
				
				$("body")
				.mousemove(function(e) {
					if (pan) {
						scroll(oldPageX - e.pageX, oldPageY - e.pageY);
						oldPageX = e.pageX;
						oldPageY = e.pageY;
					}
				}).mouseup(function() {
					pan = false;
				}).mouseleave(function() {
					pan = false;
				});
				
				var scrollTimer;
				var globalX = %5$d;
				var globalY = %6$d;
				var pan = false;
				var oldPageX = 0;
				var oldPageY = 0;
				var MAP_RECT_SIZE = '.self::MAP_RECT_SIZE.';
				
				$(".scroll_item").each(function() {
					$(this).css("left", globalX + "px");
					$(this).css("top", globalY + "px");
				});
			', $this->getID(), $this->path->getID(), (self::MAP_HEIGHT - $this->viewRectSize) * self::MAP_RECT_SIZE, (self::MAP_WIDTH - $this->viewRectSize) * self::MAP_RECT_SIZE, - $this->viewRectX * self::MAP_RECT_SIZE, - $this->viewRectY * self::MAP_RECT_SIZE)
		);
	}
	
	public function setViewCenterX($centerX) {
		$this->viewRectX = $centerX - round($this->viewRectSize / 2);
	}
	
	public function getViewCenterY($centerY) {
		$this->viewRectY = $centerY - round($this->viewRectSize / 2);
	}
	
	public function realToViewPositionX($x) {
		return ($x - $this->getViewRectX()) * self::MAP_RECT_SIZE;
	}
	
	public function realToViewPositionY($y) {
		return ($y - $this->getViewRectY()) * self::MAP_RECT_SIZE;
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getZoom() {
		return $this->zoom;
	}
	
	public function setZoom($zoom) {
		$this->zoom = $zoom;
	}
	
	public function getViewRectX() {
		return $this->viewRectX;
	}
	
	public function getViewRectY() {
		return $this->viewRectY;
	}
	
	public function getViewRectSize() {
		return $this->viewRectSize;
	}
	
	public function getMapLayer() {
		return '<div style="width:'.(self::MAP_WIDTH * self::MAP_RECT_SIZE).'px; height:'.(self::MAP_HEIGHT * self::MAP_RECT_SIZE).'px; background:#2D78BE url('.Rakuun_Intern_Mode::getCurrentMode()->getMapImagePath().') no-repeat left top; position:absolute;" id="rakuun_map_map_layer" class="scroll_item"></div>';
	}
	
	public function getCityX() {
		return $this->cityX;
	}
	
	public function getCityY() {
		return $this->cityY;
	}
	
	public function setTarget($cityX, $cityY, Rakuun_DB_User $targetUser = null) {
		$this->targetUser = $targetUser;
		$this->cityX = $cityX;
		$this->cityY = $cityY;
		$this->viewRectX = $cityX;
		$this->viewRectY = $cityY;
		if ($this->viewRectX == 0 && $this->viewRectY == 0) {
			$this->viewRectX = Rakuun_User_Manager::getCurrentUser()->cityX;
			$this->viewRectY = Rakuun_User_Manager::getCurrentUser()->cityY;
		}
		$this->viewRectX -= $this->viewRectSize / 2;
		if ($this->viewRectX < 0)
			$this->viewRectX = 0;
		if ($this->viewRectX > self::MAP_WIDTH - $this->viewRectSize)
			$this->viewRectX = self::MAP_WIDTH - $this->viewRectSize;
		$this->viewRectY -= $this->viewRectSize / 2;
		if ($this->viewRectY < 0)
			$this->viewRectY = 0;
		if ($this->viewRectY > self::MAP_HEIGHT - $this->viewRectSize)
			$this->viewRectY = self::MAP_HEIGHT - $this->viewRectSize;
	}
}

?>