<? $this->params->navigation->display(); ?>

<? foreach($this->panels as $panel): ?>
	<? $panel->display(); ?>
	<br class="clear" />
<? endforeach ?>