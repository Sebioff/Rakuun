<? $this->params->navigation->display(); ?>

<? foreach($this->panels as $panel): ?>
	<? $panel->display(); ?>
	<hr />
<? endforeach ?>