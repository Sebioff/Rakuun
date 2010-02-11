<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>

<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
<? endif; ?>
<? $this->displayPanel('description'); ?>
<br class="clear" />
<? $this->displayPanel('intern'); ?>
<br class="clear" />
<? $this->displayPanel('membersbox'); ?>
<br class="clear" />
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