<? foreach ($this->panels as $panel): ?>
	<? $panel->display(); ?>
<? endforeach; ?>
<? if (!empty($this->panels)): ?>
	<br class="clear" />
	<hr/>
<? endif; ?>
