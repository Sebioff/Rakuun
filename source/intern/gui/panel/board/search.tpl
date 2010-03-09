<? $this->displayLabelForPanel('board'); ?>
<? $this->displayPanel('board'); ?>
<? $this->displayPanel('search'); ?>
<? if ($this->hasPanel('result')): ?>
	<br class="clear" />
	<? $this->displayPanel('result'); ?>
<? endif; ?>