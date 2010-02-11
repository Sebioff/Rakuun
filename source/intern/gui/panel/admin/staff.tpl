<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayPanel('user') ?>
<br class="clear" />
<? $this->displayPanel('groups') ?>
<br class="clear" />
<? $this->displayPanel('register') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Spieler erfolgreich eingetragen
<? endif; ?>