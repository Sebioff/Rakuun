<? foreach ($this->panels as $panel): ?>
	<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
	<br class="clear" />
<? endforeach; ?>
