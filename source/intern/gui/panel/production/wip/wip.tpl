<? $wip = $this->getProducer()->getWIP() ?>
<? $currentWIP = $wip[0] ?>
<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $currentWIP->getType(), 'id' => $currentWIP->getInternalName())); ?>">
	<?= $currentWIP->getWIPItem()->getName() ?>
</a>
(Stufe <?= $currentWIP->getLevel() ?>)
<br />
<? $this->displayPanel('countdown') ?>
<? $queueItems = count($wip) ?>
<? if ($queueItems > 1 && $this->getEnableQueueView()): ?>
	<hr />
	In der Warteschlange:
	<ul>
	<? $totalQueueTime = 0 ?>
	<? for ($i = 1; $i < $queueItems; $i++): ?>
		<li>
			<? $wip[$i]->display(); ?>
		</li>
		<? $totalQueueTime += $wip[$i]->getTimeCosts(); ?>
	<? endfor ?>
	</ul>
	<hr />
	Gesamtdauer der Warteschlange: <?= Rakuun_Date::formatCountDown($totalQueueTime) ?>
	<br />
	Fertigstellung: <?= date('d.m.Y, H:i:s', time() + $totalQueueTime + $currentWIP->getRemainingTime()) ?>
<? endif ?>