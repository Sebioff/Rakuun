<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if (count($this->params->applications) > 0): ?>
	<? foreach ($this->params->applications as $application): ?>
		<?= $application['record']->alliance->name; ?>: <?= $application['record']->text; ?>
		<br/>
		<? $application['options']->display(); ?>
		<br class="clear" />
	<? endforeach; ?>
	<? $this->displayPanel('submit'); ?>
<? endif; ?>
