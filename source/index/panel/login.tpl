<div id="loginform">
	<? if ($this->hasErrors()): ?>
		<? $this->displayErrors(); ?>
	<? endif; ?>
	<? $this->displayLabelForPanel('username'); ?> <? $this->displayPanel('username'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
	<br class="clear" />
	<? if ($this->hasPanel('captcha')): ?>
		<? $this->displayLabelForPanel('captcha'); ?> <? $this->displayPanel('captcha'); ?>
		<br class="clear" />
	<? endif; ?>
	<? $this->displayPanel('base64'); ?>
	<? $this->displayPanel('submit'); ?>
</div>