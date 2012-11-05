<?
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
?>
<style type="text/css">
	.rakuun_city {
		height:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
		width:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
	}
</style>

<div id="ctn_map">
	<? $this->displayPanel('scroll_up'); ?>
	<? $this->displayPanel('scroll_left'); ?>
	
	
	<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
		<?= $this->getMapLayer(); ?>
		<? $this->displayPanel('path'); ?>
		<? if ($this->getCityX() || $this->getCityY()): ?>
			<? $indicatorX = $this->getCityX(); ?>
			<? $indicatorY = $this->getCityY(); ?>
		<? else: ?>
			<? $indicatorX = Rakuun_User_Manager::getCurrentUser()->cityX; ?>
			<? $indicatorY = Rakuun_User_Manager::getCurrentUser()->cityY; ?>
		<? endif; ?>
		<div id="rakuun_map_indicator" class="scrolling_item" style="left:<?= ($this->realToViewPositionX($indicatorX) - 2); ?>px;top:<?= ($this->realToViewPositionY($indicatorY) - 2); ?>px;"></div>
		<? $this->displayPanel('items'); ?>
	</div>
	
	
	<? $this->displayPanel('scroll_right'); ?>
	<br class="clear" />
	<? $this->displayPanel('scroll_down'); ?>
</div>
<? $this->displayPanel('target'); ?>
<? $this->displayPanel('directorytop'); ?>
<? $this->displayPanel('directorylast'); ?>
<br class="clear" />
<? $this->displayPanel('legend'); ?>