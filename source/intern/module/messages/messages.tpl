<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>

<? $this->displayPanel('categories') ?>
<? $this->displayPanel('directory'); ?>
<? $this->displayPanel('send') ?>
<br class="clear" />
<? if ($this->hasPanel('view')): ?>
	<? $this->displayPanel('view'); ?>
<? endif; ?>