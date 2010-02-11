<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayPanel('deleteuser') ?>
<br class="clear" />
<? $this->displayPanel('delete') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Spieler erfolgreich gelöscht
<? endif; ?>