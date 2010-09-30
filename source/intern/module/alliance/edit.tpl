<div class="alliance_edit_leftcol">
	<? if ($this->hasPanel('edit')): ?>
		<? $this->displayPanel('edit'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('mail')): ?>
		<? $this->displayPanel('mail'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('invite')): ?>
		<? $this->displayPanel('invite'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('delete')): ?>
		<? $this->displayPanel('delete'); ?>
	<? endif; ?>
</div>
<div class="alliance_edit_rightcol">
	<? if ($this->hasPanel('ranks')): ?>
		<? $this->displayPanel('ranks'); ?>
		<? $this->displayPanel('new_rank'); ?>
		<br class="clear"/>
	<? endif; ?>
	<? if ($this->hasPanel('activity')): ?>
		<? $this->displayPanel('activity'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('kick')): ?>
		<? $this->displayPanel('kick'); ?>
	<? endif; ?>
</div>



