<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div id="ctn_rakuun_alliance_leftcol">
	<? if ($this->hasPanel('picturebox')): ?>
		<? $this->displayPanel('picturebox'); ?>
	<? endif; ?>
	<? $this->displayPanel('internbox'); ?>
	<? if ($this->hasPanel('pollbox')): ?>
		<? $this->displayPanel('pollbox'); ?>
	<? endif; ?>
	<? $this->displayPanel('boardbox'); ?>
</div>
<? $this->displayPanel('shoutboxbox'); ?>