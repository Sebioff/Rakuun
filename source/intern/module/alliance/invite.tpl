<?php $this->params->navigation->display(); ?>
<? $this->displayPanel('counter'); ?>
<? if ($this->hasPanel('invite')): ?>
	<? $this->displayPanel('invite') ?>
<? endif; ?>