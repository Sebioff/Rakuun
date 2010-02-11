<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<hr />
<? $this->displayLabelForPanel('text') ?> <? $this->displayPanel('text') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>