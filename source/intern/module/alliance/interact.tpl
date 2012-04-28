<? $this->displayPanel('accountbox'); ?>
<? $this->displayPanel('depositbox'); ?>
<? if ($this->hasPanel('leavebox')): ?>
	<br class="clear" />
	<? $this->displayPanel('leavebox'); ?>
<? endif; ?>