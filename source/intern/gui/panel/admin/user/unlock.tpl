<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayPanel('lockedusers') ?>
<br class="clear" />
<? $this->displayPanel('unlock') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Spieler erfolgreich entsperrt
<? endif; ?>