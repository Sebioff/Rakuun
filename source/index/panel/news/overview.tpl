<? foreach ($this->params->news as $newsEntry): ?>
	<? $newsEntry->display(); ?>
<? endforeach; ?>