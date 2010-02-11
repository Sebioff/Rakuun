<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<? $this->displayLabelForPanel('name') ?> <? $this->displayPanel('name') ?>
<br class="clear" />
<? $this->displayPanel('privileges') ?>
<h2>Mitglieder</h2>
<? $this->displayPanel('members') ?>
<? $this->displayPanel('submit') ?>