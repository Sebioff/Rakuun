<? $this->displayPanel('wip'); ?>
<br class="clear" />
<? foreach($this->params->wipPanels as $panel): ?>
	<? $panel->display(); ?>
<? endforeach ?>