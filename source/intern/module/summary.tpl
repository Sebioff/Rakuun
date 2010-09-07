<div id="ctn_summary_pointlists">
	<? $this->displayPanel('buildingsbox'); ?>
	<? $this->displayPanel('technologiesbox'); ?>
	<? $this->displayPanel('unitsbox'); ?>
</div>
<br class="clear" />
<div id="ctn_summary_unitstats">
	<? $this->displayPanel('lostunits'); ?>
	<? $this->displayPanel('destroyedunits'); ?>
</div>
<br class="clear" />
<div id="ctn_summary_buildingstats">
	<? $this->displayPanel('lostbuildings'); ?>
	<? $this->displayPanel('destroyedbuildings'); ?>
</div>
<div id="ctn_summary_mixedstats">
	<? $this->displayPanel('buildingevents'); ?>
	<? $this->displayPanel('ressources'); ?>
	<? $this->displayPanel('fights'); ?>
</div>