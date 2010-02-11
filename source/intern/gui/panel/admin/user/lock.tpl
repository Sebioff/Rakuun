<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayPanel('lockuser') ?>
<br class="clear" />
<? $this->displayPanel('lock') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Spieler erfolgreich gesperrt
<? endif; ?>