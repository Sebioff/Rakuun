<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>

<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
<? endif; ?>
<? $this->displayPanel('description'); ?>
<? $this->displayPanel('memberbox'); ?>
<? if ($this->hasPanel('application')): ?>
	<br class="clear" />
	<? $this->displayPanel('application'); ?>
<? endif; ?>