<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayLabelForPanel('lockuser') ?><? $this->displayPanel('lockuser') ?>
<br class="clear" />
<? $this->displayLabelForPanel('timeban') ?> <? $this->displayPanel('timeban') ?>
<br class="clear" />
<? $this->displayPanel('lock') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Spieler erfolgreich gesperrt
<? endif; ?>