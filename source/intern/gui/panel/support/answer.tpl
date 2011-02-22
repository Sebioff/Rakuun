<div <?= $this->getAttributeString(); ?>>
	<? if($this->hasMessages()): ?>
		<? $this->displayMessages(); ?>
	<? endif; ?>
	<? if ($this->params->user): ?>
		<? $this->displayLabelForPanel('recipient'); ?> <? $this->displayPanel('recipient'); ?>
		<br class="clear" />
		<? $this->displayLabelForPanel('subject'); ?> <? $this->displayPanel('subject'); ?>
		<br class="clear" />
		<? $this->displayLabelForPanel('message'); ?> <? $this->displayPanel('message'); ?>
		<br class="clear" />
	<? endif; ?>
	<? $this->displayPanel('addepted'); ?>
	<? if ($this->params->user): ?>
		<? $this->displayPanel('send'); ?>
	<? endif; ?>
</div>