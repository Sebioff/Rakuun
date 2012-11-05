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
<? $wip = $this->getProducer()->getWIP(); ?>
<? $currentWIP = $wip[0]; ?>
<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $currentWIP->getType(), 'id' => $currentWIP->getInternalName())); ?>">
	<?= $currentWIP->getWIPItem()->getNameForAmount(); ?>
</a>
(x<?= Text::formatNumber($currentWIP->getAmount()); ?>)
<div class="controls">
	<? $this->displayPanel('pause'); ?>
	<? $this->displayPanel('cancel'); ?>
</div>
<br class="clear" />
<? if (Rakuun_User_Manager::getCurrentUser()->productionPaused): ?>
	Produktion pausiert.
<? elseif (!$currentWIP->meetsTechnicalRequirements()): ?>
	<a href="<?= App::get()->getInternModule()->getSubmodule('techtree')->getUrl(); ?>#<?= $currentWIP->getWIPItem()->getInternalName(); ?>">Fehlende technische Voraussetzungen.</a>
<? else: ?>
	<? if ($currentWIP->getAmount() > 1): ?>
		Nächste Einheit fertiggestellt in: <? $this->displayPanel('countdown'); ?>
		<br/>
	<? endif; ?>
	Alle Einheiten fertiggestellt in: <? $this->displayPanel('countdown_total'); ?>
<? endif; ?>
<br class="clear"/>
<? $queueItems = count($wip); ?>
<? if ($queueItems > 1 && $this->getEnableQueueView()): ?>
	<hr />
	In der Warteschlange:
	<ul>
	<? $totalQueueTime = 0; ?>
	<? for ($i = 1; $i < $queueItems; $i++): ?>
		<li>
			<? $wip[$i]->display(); ?>
			<br class="clear"/>
		</li>
		<? $totalQueueTime += $wip[$i]->getTimeCosts(); ?>
	<? endfor; ?>
	</ul>
	<hr />
	Gesamtdauer der Warteschlange: <?= Rakuun_Date::formatCountDown($totalQueueTime); ?>
	<br />
	Fertigstellung: <?= date('d.m.Y, H:i:s', time() + $totalQueueTime + $currentWIP->getTotalRemainingTime()); ?>
<? endif; ?>