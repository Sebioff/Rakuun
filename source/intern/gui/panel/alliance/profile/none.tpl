<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<?= $this->displayPanel('search') ?>
<br class="clear" />
<?= $this->displayPanel('found') ?>