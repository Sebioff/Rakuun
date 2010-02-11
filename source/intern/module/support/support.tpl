<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>

<? $this->displayPanel('categories') ?>
<br class="clear" />
<? $this->displayPanel('view') ?>