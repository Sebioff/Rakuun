<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? foreach ($this->panels as $panel): ?>
	<? if (strpos($panel->getName(), 'poll') === 0): ?>
		<? $panel->display(); ?>
		<hr />
	<? endif; ?>
<? endforeach; ?>