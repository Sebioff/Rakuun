<? foreach ($this->params->events as $event): ?>
	<?= date('d.m.Y, H:i:s', $event->time); ?>: <?= Rakuun_Intern_Event::getTextForEvent($event); ?>
	<hr/>
<? endforeach; ?>
<? $this->displayPanel('pages'); ?>