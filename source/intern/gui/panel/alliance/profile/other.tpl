<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
<? endif; ?>
<? $this->displayPanel('externbox'); ?>
<? $this->displayPanel('memberbox'); ?>
<br class="clear" />
<? $this->displayPanel('databases'); ?>
<br class="clear" />
<? if ($this->hasPanel('application')): ?>
	<? $this->displayPanel('application'); ?>
<? endif; ?>
<? $this->displayPanel('diplomacy'); ?>