<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<ul>
	<li><? $this->displayPanel('tutorial'); ?></li>
</ul>
<br class="clear" />
<? $this->displayPanel('submit'); ?>