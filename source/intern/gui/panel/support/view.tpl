<div <?= $this->getAttributeString() ?>>
	<? foreach ($this->getEnvelopes() as $envelope): ?>
		<? $envelope->display(); ?>
	<? endforeach; ?>
	
	<? if ($this->getPageCount() > 1): ?>
		<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
	<? endif; ?>
</div>