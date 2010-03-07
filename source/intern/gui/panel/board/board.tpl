<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>

<? if ($this->hasPanel('markread')): ?>
	<? $this->displayPanel('markread'); ?>
<? endif; ?>
<? $this->displayPanel('board'); ?>
<? if ($this->getPageCount() > 1): ?>
	<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
	<hr />
<? endif; ?>
<hr />
<? if ($this->hasPanel('name')): ?>
	<? $this->displayPanel('name'); ?>
<? endif; ?>
<? if ($this->hasPanel('addboard')): ?>
	<? $this->displayPanel('addboard'); ?>
<? endif; ?>