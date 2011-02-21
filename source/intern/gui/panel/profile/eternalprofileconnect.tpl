<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayLabelForPanel('username'); ?> <? $this->displayPanel('username'); ?>
<br class="clear"/>
<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
<br class="clear"/>
<? $this->displayPanel('connect'); ?>