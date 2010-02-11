<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?> onClick="window.location.href='<?= $this->params->url ?>'">
	<a href="<?= $this->params->url ?>">
		<? $this->displayLabelForPanel('user'); ?>: <? $this->displayPanel('user'); ?>
		<br/>
		Betreff: <?= Text::escapeHTML($this->getTicket()->subject); ?>
		<br/>
		<? $this->displayLabelForPanel('date'); ?>: <? $this->displayPanel('date'); ?>
	</a>
</div>