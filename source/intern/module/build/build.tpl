<? $count = -1; ?>
<? foreach($this->panels as $panel): ?>
	<? $panel->display(); ?>
	<? $count++; ?>
	<? if ($count % 2 == 0): ?>
		<br class="clear" />
	<? endif; ?>
<? endforeach ?>