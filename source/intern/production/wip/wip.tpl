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
<? if ($this->getWIPItem() instanceof Rakuun_Intern_Production_CityItem): ?>
	<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $this->getWIPItem()->getType(), 'id' => $this->getWIPItem()->getInternalName())); ?>"><?= $this->getWIPItem()->getName(); ?></a> (Stufe <?= $this->getLevel(); ?>) - Dauer: <?= Rakuun_Date::formatCountDown($this->getTimeCosts()); ?>
<? else: ?>
	<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $this->getWIPItem()->getType(), 'id' => $this->getWIPItem()->getInternalName())); ?>"><?= $this->getWIPItem()->getName(); ?></a> (x<?= Text::formatNumber($this->getAmount()); ?>) - Dauer: <?= Rakuun_Date::formatCountDown($this->getTimeCosts()); ?>
<? endif; ?>
<div class="controls">
	<? if ($this->hasPanel('move_up')): ?>
		<? $this->displayPanel('move_up'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('move_down')): ?>
		<? $this->displayPanel('move_down'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('cancel')): ?>
		<? $this->displayPanel('cancel'); ?>
	<? endif; ?>
</div>