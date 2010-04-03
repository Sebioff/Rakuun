<div id="registrationform">
	<? if ($this->hasErrors()): ?>
		<? $this->displayErrors() ?>
	<? endif ?>
	<? $this->displayLabelForPanel('username') ?> <? $this->displayPanel('username') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('password') ?> <? $this->displayPanel('password') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('password_repeat') ?> <? $this->displayPanel('password_repeat') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('mail') ?> <? $this->displayPanel('mail') ?>
	<br class="clear" />
	<? $this->displayPanel('base64') ?>
	<? $this->displayPanel('submit') ?>
</div>