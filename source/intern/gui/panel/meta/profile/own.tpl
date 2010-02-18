<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('shoutbox'); ?>
<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
<? endif; ?>
<? $this->displayPanel('description'); ?>
<? $this->displayPanel('intern'); ?>
<? $this->displayPanel('membersbox'); ?>
<? if ($this->hasPanel('leave')): ?>
	<? $this->displayPanel('leave'); ?>
	<br class="clear" />
<? endif; ?>
<? if ($this->hasPanel('account')): ?>
	<? $this->displayPanel('account'); ?>
<? endif; ?>
<? if ($this->hasPanel('deposit')): ?>
	<? $this->displayPanel('deposit'); ?>
<? endif; ?>
<? if ($this->hasPanel('movements')): ?>
	<? $this->displayPanel('movements'); ?>
<? endif; ?>