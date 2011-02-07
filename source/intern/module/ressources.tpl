<? $this->displayPanel('ressource_production'); ?>
<br class="clear" />
<div id="ctn_ressource_stocks">
<? $this->displayPanel('ressource_capacity'); ?>
<? $this->displayPanel('ressource_fullstocks'); ?>
</div>
<br class="clear" />
<div id="ctn_workers_management">
	<? $this->displayPanel('workers_ironmine'); ?>
	<? $this->displayPanel('workers_berylliummine'); ?>
	<br class="clear" />
	<? if ($this->hasPanel('workers_clonomat')): ?>
		<? $this->displayPanel('workers_clonomat'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('workers_hydropower_plant')): ?>
		<? $this->displayPanel('workers_hydropower_plant'); ?>
	<? endif; ?>
</div>