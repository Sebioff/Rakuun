<? $wip = $this->getProducer()->getWIP(); ?>
<? $currentWIP = $wip[0]; ?>
<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $currentWIP->getType(), 'id' => $currentWIP->getInternalName())); ?>">
	<?= $currentWIP->getWIPItem()->getNameForAmount(); ?>
</a>
(x<?= GUI_Panel_Number::formatNumber($currentWIP->getAmount()); ?>)
<div class="controls">
	<? $this->displayPanel('pause'); ?>
	<? $this->displayPanel('cancel'); ?>
</div>
<br class="clear" />
<? if (Rakuun_User_Manager::getCurrentUser()->productionPaused): ?>
	Produktion pausiert.
<? elseif (!$currentWIP->meetsTechnicalRequirements()): ?>
	<a href="<?= App::get()->getInternModule()->getSubmodule('techtree')->getUrl(); ?>#<?= $currentWIP->getWIPItem()->getInternalName(); ?>">Fehlende technische Vorraussetzungen.</a>
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