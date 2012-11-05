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
<div id="<?= $this->getID(); ?>" class="ctn_board_content">
	<? if ($this->hasMessages()): ?>
		<? $this->displayMessages(); ?>
	<? endif; ?>
	
	<? if ($this->hasPanel('markread')): ?>
		<? $this->displayPanel('markread'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('moderatelink')): ?>
		<? $this->displayPanel('moderatelink'); ?>
	<? endif; ?>
	<? $this->displayPanel('board'); ?>
	<? if ($this->showPages()): ?>
		<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
		<hr />
	<? endif; ?>
	<hr />
	<? if ($this->hasPanel('name')): ?>
		<? $this->displayPanel('name'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('addboard')): ?>
		<? $this->displayPanel('addboard'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('suchen')): ?>
		<? $this->displayPanel('suchen'); ?>
	<? endif; ?>
</div>