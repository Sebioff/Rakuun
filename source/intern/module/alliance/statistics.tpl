<?php $this->params->navigation->display(); ?>

<? if ($this->hasPanel('ressources')): ?>
	<? $this->displayPanel('ressources'); ?>
	<br class="clear" />
<? endif; ?>
<? if ($this->hasPanel('army')): ?>
	<? $this->displayPanel('army'); ?>
<? endif; ?>