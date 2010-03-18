<div id="ctn_alliance_profile">
	<? if ($this->hasPanel('picture')): ?>
		<? $this->displayPanel('picture'); ?>
	<? endif; ?>
	<? $this->displayPanel('description'); ?>
	<br class="clear" />
	<? $this->displayPanel('intern'); ?>
	<br class="clear" />
	<? $this->displayPanel('membersbox'); ?>
	<br class="clear" />
	<? if ($this->hasPanel('account')): ?>
		<? $this->displayPanel('account'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('deposit')): ?>
		<? $this->displayPanel('deposit'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('movements')): ?>
		<? $this->displayPanel('movements'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('leave')): ?>
		<? $this->displayPanel('leave'); ?>
		<br class="clear" />
	<? endif; ?>
</div>
<div id="ctn_alliance_shoutbox">
	<? $this->displayPanel('shoutbox'); ?>
</div>
