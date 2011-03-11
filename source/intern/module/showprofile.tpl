<? if ($this->hasPanel('showprofile')): ?>
	<? $this->displayPanel('showprofile'); ?>
<? endif; ?>
<? if ($this->hasPanel('reportsbox')): ?>
	<br class="clear" />
	<? $this->displayPanel('armybox'); ?>
	<? $this->displayPanel('buildingsbox'); ?>
	<br class="clear" />
	<? $this->displayPanel('reportsbox'); ?>
	<? $this->displayPanel('detailsbox'); ?>
<? endif; ?>