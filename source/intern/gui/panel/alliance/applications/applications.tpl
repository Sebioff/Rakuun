<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if (count($this->params->applications) > 0): ?>
	<? foreach ($this->params->applications as $application): ?>
		<?= $application['record']->user->name; ?>: <?= $application['record']->text; ?>
		<br/>
		<? $application['options']->display(); ?>
		<br class="clear" />
		<div id="<?= $application['reason']->getID() ?>-container">
			<? $this->displayLabelForPanel($application['reason']->getName()); ?> <? $application['reason']->display(); ?>
			<br class="clear" />
		</div>
	<? endforeach; ?>
	<? $this->displayPanel('submit'); ?>
<? endif; ?>
