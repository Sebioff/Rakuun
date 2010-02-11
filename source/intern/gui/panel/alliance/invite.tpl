<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<? $this->displayLabelForPanel('users'); ?> <? $this->displayPanel('users'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('text'); ?> <? $this->displayPanel('text'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('info'); ?> <? $this->displayPanel('info'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>