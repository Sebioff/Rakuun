<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div id="ctn_alliance_description">
	<? if ($this->hasPanel('picture')): ?>
		<? $this->displayPanel('picture'); ?>
	<? endif; ?>
	<? $this->displayPanel('externbox'); ?>
	<? $this->displayPanel('diplomacy'); ?>
	<? $this->displayPanel('databases'); ?>
	<? if ($this->hasPanel('application')): ?>
		<? $this->displayPanel('application'); ?>
	<? endif; ?>
</div>
<? $this->displayPanel('memberbox'); ?>
