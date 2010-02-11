<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayLabelForPanel('logfiles') ?> <? $this->displayPanel('logfiles') ?> <? $this->displayPanel('show') ?>
<br class="clear" />
<? $this->displayLabelForPanel('logfile_content') ?> <? $this->displayPanel('logfile_content') ?>