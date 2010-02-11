<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<? $this->displayLabelForPanel('key'); ?> <? $this->displayPanel('key'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>