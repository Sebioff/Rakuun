<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $this->displayLabelForPanel('ip') ?> <? $this->displayPanel('ip') ?>
<br class="clear" />
<? $this->displayLabelForPanel('hostname') ?> <? $this->displayPanel('hostname') ?>
<br class="clear" />
<? $this->displayLabelForPanel('browser') ?> <? $this->displayPanel('browser') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors() && count($this->params->logs)): ?>
	<br class="clear" />
	<? 	$this->addPanel($table = new GUI_Panel_Table('table', 'Suchergebnis')); ?>
	<? 	$table->addHeader(array('Aktion', 'Darum', 'User', 'IP', 'Hostname', 'Browser')); ?>
	<? foreach ($this->params->logs as $log): ?>
		<?	$date = new GUI_Panel_Date('date'.$log->getPK(), $log->time); ?>
		<?	$table->addLine(array(Rakuun_Intern_Log::getActionDescription($log->action), $date, $log->user->name, $log->ip, $log->hostname, $log->browser)); ?>
	<? endforeach; ?>
	<? $this->displayPanel('table') ?>
<? endif; ?>