<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>

<div id="ctn_messages_top">
	<? $this->displayPanel('categories'); ?>
	<? $this->displayPanel('directory'); ?>
	<? $this->displayPanel('send'); ?>
</div>
<br class="clear" />
<? if ($this->hasPanel('view')): ?>
	<? $this->displayPanel('view'); ?>
<? endif; ?>