<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->hasPanel('boardlink')): ?>
	<? $this->displayPanel('boardlink'); ?>
<? endif; ?>
<? $this->displayPanel('list'); ?>