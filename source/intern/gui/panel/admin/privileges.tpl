<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayLabelForPanel('teammember') ?> <? $this->displayPanel('teammember') ?>
<br class="clear" />
<? $this->displayPanel('groups') ?>
<br class="clear" />
<? $this->displayPanel('update') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Rechte erfolgreich geändert
<? endif; ?>