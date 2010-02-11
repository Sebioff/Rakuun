<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? $this->displayPanel('create_news') ?>
<? $this->displayPanel('update') ?>
<br />
<? if (isset($this->params->conflicts) && $this->params->conflicts): ?>
	<span style="color:#ff0000; font-weight:bold">Es gab Konflikte beim Updaten!</span>
	<br/>
<? endif; ?>
<? $this->displayPanel('update_log') ?>