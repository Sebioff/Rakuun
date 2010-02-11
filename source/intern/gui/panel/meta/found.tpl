<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayLabelForPanel('name'); ?> <? $this->displayPanel('name'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>