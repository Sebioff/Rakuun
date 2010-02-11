<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('question'); ?>
<? $this->displayPanel('answers'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>