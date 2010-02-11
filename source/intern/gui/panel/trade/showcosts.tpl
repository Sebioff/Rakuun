<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $this->displayLabelForPanel('transport') ?> <? $this->displayPanel('transport') ?>
<br class="clear" />
<? $this->displayLabelForPanel('transportcosts') ?> <? $this->displayPanel('transportcosts') ?>
<br class="clear" />
<? $this->displayLabelForPanel('holecosts') ?> <? $this->displayPanel('holecosts') ?>
<br class="clear" />