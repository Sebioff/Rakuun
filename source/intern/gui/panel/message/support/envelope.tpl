<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?> onClick="window.location.href='<?= $this->params->url ?>'">
	<a href="<?= $this->params->url ?>">
		<? $this->displayLabelForPanel('supporter'); ?>: <? $this->displayPanel('supporter'); ?>
		<br/>
		Betreff: <?= Text::escapeHTML($this->getMessage()->subject); ?>
		<br/>
		<? $this->displayLabelForPanel('date'); ?>: <? $this->displayPanel('date'); ?>
	</a>
</div>