<div class="ctn_board_content">
	<? if ($this->hasMessages()): ?>
		<? $this->displayMessages(); ?>
	<? endif; ?>
	<? $this->displayPanel('globalbox'); ?>
	<br class="clear" />
	<? if ($this->hasPanel('alliancebox')): ?>
		<? $this->displayPanel('alliancebox'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('metabox')): ?>
		<? $this->displayPanel('metabox'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('adminbox')): ?>
		<? $this->displayPanel('adminbox'); ?>
		<br class="clear" />
	<? endif; ?>
</div>