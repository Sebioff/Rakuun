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
<? if ($this->getMeta()->dancertiaStarttime + RAKUUN_SPEED_DANCERTIA_STARTTIME > time()): ?>
	Die Meta "<? $this->displayPanel('metalink'); ?>" bereitet den Start der "Dancertia" vor!
	<br/>
	Bei <? $this->displayPanel('userlink'); ?> wurde einer von <?= $this->params->currentShieldCount; ?> Schildgeneratoren entdeckt!
	<br/>
	<strong>Start-Countdown:</strong>
	<br/>
	<? $this->displayPanel('countdown'); ?>
<? else: ?>
	Die Meta "<?= $this->getMeta()->name; ?>" konnte die "Dancertia" starten, hat nun die Macht über ganz Rakuun zu herrschen und hat diese Runde gewonnen!
<? endif; ?>