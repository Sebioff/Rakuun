<? foreach($this->panels as $panel): ?>
	<? $panel->display(); ?>
	<br class="clear" />
	<hr />
<? endforeach ?>