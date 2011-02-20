<? foreach ($this->params->igmPanels as $igmPanel): ?>
	<? $igmPanel->display(); ?>
	<br class="clear" />
<? endforeach; ?>