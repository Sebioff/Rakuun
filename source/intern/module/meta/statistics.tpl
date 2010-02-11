<? $this->params->navigation->display(); ?>
<? foreach ($this->params->panels as $panel): ?>
	<? $panel['alliancelink']->display(); ?>
	<br />
	<? $panel['ressources']->display(); ?>
	<br class="clear" />
	<? $panel['army']->display(); ?>
	<br class="clear" />
<? endforeach; ?>