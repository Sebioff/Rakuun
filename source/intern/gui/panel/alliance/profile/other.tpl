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
<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div id="ctn_alliance_description">
	<? if ($this->hasPanel('picture')): ?>
		<? $this->displayPanel('picture'); ?>
	<? endif; ?>
	<? $this->displayPanel('externbox'); ?>
	<? if ($this->hasPanel('metabox')): ?>
		<? $this->displayPanel('metabox'); ?>
	<? endif; ?>
	<? $this->displayPanel('diplomacy'); ?>
	<? $this->displayPanel('databases'); ?>
	<? if ($this->hasPanel('application')): ?>
		<? $this->displayPanel('application'); ?>
	<? endif; ?>
</div>
<? $this->displayPanel('memberbox'); ?>