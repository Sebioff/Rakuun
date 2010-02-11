<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

Du sittest <? $this->displayPanel('sittingname'); ?>
<? $this->displayPanel('switch'); ?>
<? $this->displayPanel('delete'); ?>