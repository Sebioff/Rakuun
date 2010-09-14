<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<? if ($this->hasPanel('selections')): ?>
		<div id="ctn_messages_actions">
			<? $this->displayPanel('selections'); ?> <? $this->displayPanel('actions'); ?> <? $this->displayPanel('execute_actions'); ?>
		</div>
		<br />
	<? endif; ?>

	<? foreach ($this->getEnvelopes() as $envelope): ?>
		<? $envelope->display(); ?>
	<? endforeach; ?>
	
	<? if ($this->getPageCount() > 1): ?>
		<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
	<? endif; ?>
</div>