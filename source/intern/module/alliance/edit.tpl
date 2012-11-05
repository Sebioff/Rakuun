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
<div class="alliance_edit_leftcol">
	<? if ($this->hasPanel('edit')): ?>
		<? $this->displayPanel('edit'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('mail')): ?>
		<? $this->displayPanel('mail'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('invite')): ?>
		<? $this->displayPanel('invite'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('delete')): ?>
		<? $this->displayPanel('delete'); ?>
	<? endif; ?>
</div>
<div class="alliance_edit_rightcol">
	<? if ($this->hasPanel('ranks')): ?>
		<? $this->displayPanel('ranks'); ?>
		<? $this->displayPanel('new_rank'); ?>
		<br class="clear"/>
	<? endif; ?>
	<? if ($this->hasPanel('activity')): ?>
		<? $this->displayPanel('activity'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('kick')): ?>
		<? $this->displayPanel('kick'); ?>
	<? endif; ?>
</div>



