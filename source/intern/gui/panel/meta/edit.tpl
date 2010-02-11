<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<? $this->displayLabelForPanel('intern') ?> <? $this->displayPanel('intern') ?>
<br class="clear" />
<? $this->displayLabelForPanel('description') ?> <? $this->displayPanel('description') ?>
<br class="clear" />
<? $this->displayLabelForPanel('picture'); ?> <? $this->displayPanel('picture'); ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>