<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<? $this->displayLabelForPanel('username') ?> <? $this->displayPanel('username') ?>
<br class="clear" />
<? $this->displayLabelForPanel('mail') ?> <? $this->displayPanel('mail') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>