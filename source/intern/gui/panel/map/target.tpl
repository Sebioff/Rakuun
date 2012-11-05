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
<div class="rakuun_map_target_panel">
	<? if ($this->hasMessages()): ?>
		<? $this->displayMessages(); ?>
	<? endif; ?>
	<? if ($this->state->getValue() == Rakuun_Intern_GUI_Panel_Map_Target::STATE_REVIEWING): ?>
		<? if (!($target = $this->getTargetUser())): ?>
			<? $target = $this->targetX->getValue().':'.$this->targetY->getValue(); ?>
		<? else: ?>
			<? if (Rakuun_User_Manager::getCurrentUser()->alliance && $target->alliance && Rakuun_User_Manager::getCurrentUser()->alliance->getPK() == $target->alliance->getPK()): ?>
				Achtung: du greifst ein Mitglied deiner Allianz an!
				<br/>
			<? endif; ?>
			<? if ($target->isOnline()): ?>
				Achtung: Der Spieler ist online!
				<br/>
			<? endif; ?>
			<? $target = $target->name; ?>
		<? endif; ?>
		Ziel: <?= $target; ?>
		<br/>
		Dauer: <?= Rakuun_Date::formatCountDown($this->getArmy()->targetTime - time()); ?>
		<br/>
		Voraussichtliche Ankunft: <? $date = new GUI_Panel_Date('arrivingtime', $this->getArmy()->targetTime, '', GUI_Panel_Date::FORMAT_TIME); $date->display(); ?>
		<? $this->displayPanel('target'); ?> <? $this->displayPanel('target_x'); ?><? $this->displayPanel('target_y'); ?>
	<? else: ?>
		<? $this->displayLabelForPanel('target'); ?> <? $this->displayPanel('target'); ?>
		<br class="clear" />
		<? $this->displayPanel('target_coords_label'); ?> <? $this->displayPanel('target_x'); ?><? $this->displayPanel('target_y'); ?>
	<? endif; ?>
	<br class="clear" />
	<hr />
	<? $this->displayPanel('unit_input'); ?>
	<? if ($this->hasPanel('spydrone') || $this->hasPanel('cloaked_spydrone')): ?>
		<h2>Spionage</h2>
		<? if ($this->hasPanel('spydrone')): ?>
			<? $this->displayLabelForPanel('spydrone'); ?> <? $this->displayPanel('spydrone'); ?>
			<br class="clear" />
		<? endif; ?>
		<? if ($this->hasPanel('cloaked_spydrone')): ?>
			<? $this->displayLabelForPanel('cloaked_spydrone'); ?> <? $this->displayPanel('cloaked_spydrone'); ?>
			<br class="clear" />
		<? endif; ?>
		<? if ($this->hasPanel('spy_label')): ?>
			<? $this->displayPanel('spy_label'); ?>
		<? endif; ?>
		<hr />
	<? endif; ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('iron_priority'); ?> <? $this->displayPanel('iron_priority'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('beryllium_priority'); ?> <? $this->displayPanel('beryllium_priority'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('energy_priority'); ?> <? $this->displayPanel('energy_priority'); ?>
	<br class="clear" />
	<? $this->displayPanel('destroy_buildings_label'); ?> <? $this->displayPanel('destroy_buildings'); ?>
	<br class="clear" />
	<? $this->displayPanel('state'); ?>
	<? $this->displayPanel('submit'); ?>
</div>
