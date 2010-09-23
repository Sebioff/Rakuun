<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('picturebox'); ?>
<? $this->displayPanel('internbox'); ?>
<br class="clear" />
<? $this->displayPanel('shoutboxbox'); ?>
<? $this->displayPanel('boardbox'); ?>
<? if ($this->hasPanel('pollbox')): ?>
	<? $this->displayPanel('pollbox'); ?>
<? endif; ?>