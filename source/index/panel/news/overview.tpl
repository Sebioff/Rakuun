<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<div class="pageview_pages">Seite: <? $this->displayPanel('pages'); ?></div>
	<br class="clear"/>

	<? foreach ($this->params->news as $newsEntry): ?>
		<? $newsEntry->display(); ?>
		<br class="clear"/>
	<? endforeach; ?>
	
	<div class="pageview_pages">Seite: <? $this->displayPanel('pages'); ?></div>
</div>