<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('question'); ?>
<? if ($this->hasPanel('delete')): ?>
	<? $this->displayPanel('delete'); ?>
<? endif; ?>
<? $this->displayPanel('answers'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>