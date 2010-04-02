<? foreach (Rakuun_Intern_Quest_Factory::getAllQuests() as $quest): ?>
	Aufgabe: <?= $quest->getDescription(); ?>
	<br/>
	Belohnung: <?= $quest->getRewardDescription(); ?>
	<br/>
	Status:
	<? if (!$quest->exists()): ?>
		Nicht vergeben.
	<? else: ?>
		Vergeben an <?= $quest->getOwnerName(); ?>
	<? endif; ?>
	<hr/>
<? endforeach; ?>
