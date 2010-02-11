<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif ?>
<? $this->displayLabelForPanel('iron'); ?> <? $this->displayPanel('iron'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('beryllium'); ?> <? $this->displayPanel('beryllium'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('energy'); ?> <? $this->displayPanel('energy'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('people'); ?> <? $this->displayPanel('people'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>