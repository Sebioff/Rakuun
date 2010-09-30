<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
Kosten Eisen: <?= $this->getIronCosts(); ?>
<br />
Kosten Beryllium: <?= $this->getBerylliumCosts(); ?>
<br />
<? $this->displayLabelForPanel('name'); ?> <? $this->displayPanel('name'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('tag'); ?> <? $this->displayPanel('tag'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>