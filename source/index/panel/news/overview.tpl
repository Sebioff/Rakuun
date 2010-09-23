<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	Seite: <? $this->displayPanel('pages'); ?>
	<br class="clear"/>

	<? foreach ($this->params->news as $newsEntry): ?>
		<? $newsEntry->display(); ?>
		<br class="clear"/>
	<? endforeach; ?>
	
	Seite: <? $this->displayPanel('pages'); ?>
</div>