<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>

<? $this->displayLabelForPanel('amount'); ?>
<? $this->displayPanel('amount'); ?>
<hr class="clear" />
<? $this->displayLabelForPanel('first'); ?>
<? $this->displayPanel('first'); ?>
<? $this->displayPanel('first_radio'); ?>
<br class="clear" />
<? $this->displayPanel('slider'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('second'); ?>
<? $this->displayPanel('second'); ?>
<? $this->displayPanel('second_radio'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>