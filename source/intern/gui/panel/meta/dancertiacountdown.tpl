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