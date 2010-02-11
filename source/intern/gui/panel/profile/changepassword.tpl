<? if ($this->hasMessages()): ?>
	<? $this->displayMessages() ?>
<? endif; ?>
<? $this->displayLabelForPanel('old_password') ?> <? $this->displayPanel('old_password') ?>
<br class="clear" />
<? $this->displayLabelForPanel('password') ?> <? $this->displayPanel('password') ?>
<br class="clear" />
<? $this->displayLabelForPanel('password_repeat') ?> <? $this->displayPanel('password_repeat') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>