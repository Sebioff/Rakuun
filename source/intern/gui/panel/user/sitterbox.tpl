<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $this->displayLabelForPanel('note'); ?> (<? $this->displayPanel('sittername'); ?>) 
<br class="clear" />
<? $this->displayPanel('note'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>