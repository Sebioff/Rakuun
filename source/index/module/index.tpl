<? $this->displayPanel('register'); ?>
<br class="clear"/>
<? if ($this->hasPanel('logout_reason')): ?>
	<? $this->displayPanel('logout_reason'); ?>
	<br class="clear"/>
<? endif; ?>
<? $this->displayPanel('login'); ?>
<br class="clear"/>
<? $this->displayPanel('serverinfo'); ?>