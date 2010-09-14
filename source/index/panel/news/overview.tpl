<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<? foreach ($this->params->news as $newsEntry): ?>
		<? $newsEntry->display(); ?>
	<? endforeach; ?>
	
	<? $this->displayPanel('pages'); ?>
</div>