<div <?= $this->getAttributeString(); ?>>
	<? if($this->hasMessages()): ?>
		<? $this->displayMessages(); ?>
	<? endif ?>
	<? $this->displayLabelForPanel('recipients'); ?> <? $this->displayPanel('recipients'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('subject'); ?> <? $this->displayPanel('subject'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('newmessage'); ?> <? $this->displayPanel('newmessage'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('blindcopies'); ?> <? $this->displayPanel('blindcopies'); ?>
	<br class="clear" />
	<? $this->displayPanel('send'); ?>
</div>