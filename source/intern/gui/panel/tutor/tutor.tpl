<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('detlef'); ?>
<?= $this->params->level->getDescription(); ?>
<br class="clear" />
<? if ($this->hasPanel('first')): ?>
	<? $this->displayPanel('first'); ?>
<? endif; ?>
<? if ($this->hasPanel('back')): ?>
	<? $this->displayPanel('back'); ?>
<? endif; ?>
<? if ($this->hasPanel('next')): ?>
	<? $this->displayPanel('next'); ?>
<? endif; ?>
<? if ($this->hasPanel('last')): ?>
	<? $this->displayPanel('last'); ?>
<? endif; ?>
<? if ($this->hasPanel('end')): ?>
	<? $this->displayPanel('end'); ?>
<? endif; ?>