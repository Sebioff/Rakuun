<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

Du sittest <? $this->displayPanel('sittingname'); if ($this->getSitting()->isOnline()) echo ' ,der gerade online ist'; ?>
<? $this->displayPanel('switch'); ?>
<? $this->displayPanel('delete'); ?>