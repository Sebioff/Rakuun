<? $this->displayPanel('register'); ?>
<br class="clear"/>
<? if ($this->hasPanel('logout_reason')): ?>
	<? $this->displayPanel('logout_reason'); ?>
	<br class="clear"/>
<? endif; ?>
<? if ($this->hasPanel('login')): ?>
	<? $this->displayPanel('login'); ?>
	<br class="clear"/>
<? endif; ?>
<? $this->displayPanel('serverinfo'); ?>