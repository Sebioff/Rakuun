<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>

<? $this->displayPanel('picturebox'); ?>
<? $this->displayPanel('description'); ?>
<br class="clear" />
<? $this->displayPanel('memberbox'); ?>
<? if ($this->hasPanel('application')): ?>
	<br class="clear" />
	<? $this->displayPanel('application'); ?>
<? endif; ?>