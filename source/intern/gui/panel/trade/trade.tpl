<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>


<? $this->displayPanel('status'); ?>
<? $this->displayPanel('tradelimit'); ?>
<br />
<br />
<? $this->displayLabelForPanel('recipient'); ?> <? $this->displayPanel('recipient'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('iron'); ?> <? $this->displayPanel('iron'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('beryllium'); ?> <? $this->displayPanel('beryllium'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('energy'); ?> <? $this->displayPanel('energy'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('message'); ?> <? $this->displayPanel('message'); ?>
<br class="clear" />
<? if ($this->hasBeenSubmitted() && !$this->hasErrors() && $this->hasPanel('costs')): ?>
	<hr />
	<? $this->displayPanel('costs'); ?>
<? endif; ?>
<? $this->displayPanel('submit'); ?>