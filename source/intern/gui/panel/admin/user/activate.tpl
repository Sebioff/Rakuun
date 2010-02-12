<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayPanel('notactivatedusers') ?>
<br class="clear" />
<? $this->displayPanel('activate') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Spieler erfolgreich aktiviert
<? endif; ?>