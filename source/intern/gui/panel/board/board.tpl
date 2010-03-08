<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>

<? if ($this->hasPanel('markread')): ?>
	<? $this->displayPanel('markread'); ?>
<? endif; ?>
<? $this->displayPanel('board'); ?>
<? if ($this->showPages()): ?>
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
<? if ($this->hasPanel('suchen')): ?>
	<? $this->displayPanel('suchen'); ?>
<? endif; ?>