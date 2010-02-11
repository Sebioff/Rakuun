<? if ($this->hasMessages()): ?>
	<? $this->displayMessages() ?>
<? endif; ?>
Um die Allianz zu löschen ist dein Passwort notwendig:
<br class="clear" />
<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>