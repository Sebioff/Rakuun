<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<? $this->displayLabelForPanel('name') ?> <? $this->displayPanel('name') ?>
<br class="clear" />
<? if ($this->hasPanel('privileges')): ?>
	<? $this->displayPanel('privileges') ?>
<? endif; ?>
<h2>Mitglieder</h2>
<? $this->displayPanel('members') ?>
<? $this->displayPanel('submit') ?>