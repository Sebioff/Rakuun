<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif ?>
<? if ($this->hasPanel('userbox')): ?>
	<? $this->displayLabelForPanel('userbox'); ?> <? $this->displayPanel('userbox'); ?>
	<br class="clear" />
<? endif; ?>
<? $this->displayLabelForPanel('iron'); ?> <? $this->displayPanel('iron'); ?>
	<br class="clear" />
<? $this->displayLabelForPanel('beryllium'); ?> <? $this->displayPanel('beryllium'); ?>
	<br class="clear" />
<? $this->displayLabelForPanel('energy'); ?> <? $this->displayPanel('energy'); ?>
	<br class="clear" />
<? $this->displayLabelForPanel('people'); ?> <? $this->displayPanel('people'); ?>
	<br class="clear" />
<? $this->displayPanel('submit'); ?>