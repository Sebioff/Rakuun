<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $this->displayLabelForPanel('note'); ?> (<? $this->displayPanel('sittername'); ?>) <? $this->displayPanel('note'); ?>
<? $this->displayPanel('submit'); ?>