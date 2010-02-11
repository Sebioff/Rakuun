<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayLabelForPanel('date'); ?> <? $this->displayPanel('date'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('hour'); ?> <? $this->displayPanel('hour'); ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>