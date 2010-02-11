<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif ?>
<? $this->displayLabelForPanel('text') ?> <? $this->displayPanel('text') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>