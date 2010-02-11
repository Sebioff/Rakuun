<div <?= $this->getAttributeString() ?>>
	<? if ($this->hasPanel('selections')): ?>
		<? $this->displayPanel('selections'); ?> <? $this->displayPanel('actions'); ?> <? $this->displayPanel('execute_actions'); ?>
		<br />
		<br />
	<? endif; ?>

	<? foreach ($this->getEnvelopes() as $envelope): ?>
		<? $envelope->display(); ?>
	<? endforeach; ?>
	
	<? if ($this->getPageCount() > 1): ?>
		<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
	<? endif; ?>
</div>