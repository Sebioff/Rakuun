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
<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif ?>
Auszahlung nur an schwache Spieler, d.h.:
<br/>
weniger als <?= Text::formatNumber($this->params->averagePoints); ?> Punkte und
<br/>
weniger als <?= Text::formatNumber($this->params->averageStrength); ?> Armeestärke
<br/>
<? if ($this->hasPanel('userbox')): ?>
	<? $this->displayLabelForPanel('userbox'); ?> <? $this->displayPanel('userbox'); ?>
	<br class="clear" />
<? endif; ?>
<? $this->displayLabelForPanel('iron'); ?> <? $this->displayPanel('iron'); ?>
	<br class="clear" />
<? $this->displayLabelForPanel('beryllium'); ?> <? $this->displayPanel('beryllium'); ?>
	<br class="clear" />
<? $this->displayLabelForPanel('energy'); ?> <? $this->displayPanel('energy'); ?>
	<br class="clear" />
<? $this->displayLabelForPanel('people'); ?> <? $this->displayPanel('people'); ?>
	<br class="clear" />
<? $this->displayPanel('submit'); ?>