<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>

<? if ($this->hasPanel('log')): ?>
	<? $this->displayPanel('log'); ?>
<? endif; ?>