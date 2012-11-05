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
	<? $this->displayErrors() ?>
<? endif; ?>
<? if (!$this->getUser()): ?>
	Nichts zum bearbeiten. Klicke im Profil des Spielers, um ihn zu bearbeiten
<? else: ?>
	<? $this->displayLabelForPanel('username') ?> <? $this->displayPanel('username') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('cityname') ?> <? $this->displayPanel('cityname') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('adminnews') ?> <? $this->displayPanel('adminnews') ?>
	<br class="clear" />
	<? if ($this->hasPanel('description')): ?>
		<? $this->displayLabelForPanel('description') ?> <? $this->displayPanel('description') ?>
		<br class="clear" />
	<? endif;?>
	<? $this->displayLabelForPanel('skin') ?> <? $this->displayPanel('skin') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('mail') ?> <? $this->displayPanel('mail') ?>
	<br class="clear" />
	<? $this->displayPanel('submit') ?>
	<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
		Spieler erfolgreich bearbeitet
	<? endif; ?>
<? endif;?>