<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayLabelForPanel('cautionuser') ?> <? $this->displayPanel('cautionuser') ?>
<br class="clear" />
<? $this->displayLabelForPanel('cautionpoints') ?> <? $this->displayPanel('cautionpoints') ?>
<br class="clear" />
<? $this->displayLabelForPanel('cautionreason') ?> <? $this->displayPanel('cautionreason') ?>
<br class="clear" />
<? $this->displayPanel('caution') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
	Verwarnung erfolgreich eingetragen
<? endif; ?>
<br class="clear" />
<? $this->displayPanel('cautionlist') ?>