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
<div class="ctn_board_content">
	<? if ($this->hasMessages()): ?>
		<? $this->displayMessages(); ?>
	<? endif; ?>
	<? $this->displayPanel('globalbox'); ?>
	<br class="clear" />
	<? if ($this->hasPanel('alliancebox')): ?>
		<? $this->displayPanel('alliancebox'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('metabox')): ?>
		<? $this->displayPanel('metabox'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('adminbox')): ?>
		<? $this->displayPanel('adminbox'); ?>
		<br class="clear" />
	<? endif; ?>
</div>