<? $this->displayLabelForPanel('board'); ?>
<? $this->displayPanel('board'); ?>
<? $this->displayPanel('search'); ?>
<? if ($this->hasPanel('result')): ?>
	<? $this->displayPanel('result'); ?>
<? endif; ?>