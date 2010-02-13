<div <?= $this->getAttributeString() ?>>
	<? if($this->hasMessages()): ?>
		<? $this->displayMessages() ?>
	<? endif ?>
	<? $this->displayLabelForPanel('recipient') ?> <? $this->displayPanel('recipient') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('subject') ?> <? $this->displayPanel('subject') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('message') ?> <? $this->displayPanel('message') ?>
	<br class="clear" />
	<? $this->displayPanel('addepted') ?>
	<? $this->displayPanel('send') ?>
</div>