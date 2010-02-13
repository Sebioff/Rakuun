<? if (isset($this->params->navigation)): ?>
	<? $this->params->navigation->display(); ?>
<? endif; ?>
<? if ($this->hasPanel('shoutbox')): ?>
	<? $this->displayPanel('shoutbox'); ?>
<? endif; ?>
<? $this->displayPanel('profile'); ?>