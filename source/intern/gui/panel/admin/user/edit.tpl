<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? if (!$this->getUser()): ?>
	Nichts zum bearbeiten. Klicke im Profil des Spielers, um ihn zu bearbeiten
<? else: ?>
	<? $this->displayLabelForPanel('username') ?> <? $this->displayPanel('username') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('cityname') ?> <? $this->displayPanel('cityname') ?>
	<br class="clear" />
	<? if ($this->hasPanel('description')): ?> 
		<? $this->displayLabelForPanel('description') ?> <? $this->displayPanel('description') ?>
		<br class="clear" />
	<? endif;?>
	<? $this->displayLabelForPanel('skin') ?> <? $this->displayPanel('skin') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('mail') ?> <? $this->displayPanel('mail') ?>
	<br class="clear" />
	<? $this->displayPanel('submit') ?>
	<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
		Spieler erfolgreich bearbeitet
	<? endif; ?>
<? endif;?>