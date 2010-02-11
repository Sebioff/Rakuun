<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayLabelForPanel('subject') ?> <? $this->displayPanel('subject') ?>
<br class="clear" />
<? $this->displayLabelForPanel('message') ?> <? $this->displayPanel('message') ?>
<br class="clear" />
<? $this->displayPanel('send') ?>