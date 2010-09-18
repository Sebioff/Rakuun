<? foreach (Rakuun_Intern_Quest_Factory::getAllQuests() as $quest): ?>
	<strong>Aufgabe</strong>: <?= $quest->getDescription(); ?>
	<br/>
	<strong>Belohnung</strong>: <?= $quest->getRewardDescription(); ?>
	<br/>
	<strong>Status</strong>:
	<? if (!$quest->exists()): ?>
		Nicht vergeben.
	<? else: ?>
		Vergeben an <?= $quest->getOwnerName(); ?>
	<? endif; ?>
	<hr/>
<? endforeach; ?>
