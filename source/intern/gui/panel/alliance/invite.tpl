<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<? if ($this->hasPanel('counter')): ?>
	<? $this->displayPanel('counter'); ?>
<? endif; ?>
<? $this->displayLabelForPanel('users'); ?> <? $this->displayPanel('users'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('text'); ?> <? $this->displayPanel('text'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('info'); ?> <? $this->displayPanel('info'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>