<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif ?>
<? $this->displayLabelForPanel('subject'); ?> <? $this->displayPanel('subject'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('text'); ?> <? $this->displayPanel('text'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>