<? if (isset($this->params->navigation)): ?>
	<? $this->params->navigation->display(); ?>
<? endif; ?>
<div id="ctn_alliance_profile">
	<? $this->displayPanel('profile'); ?>
</div>
<? if ($this->hasPanel('shoutbox')): ?>
	<div id="ctn_alliance_shoutbox">
		<? $this->displayPanel('shoutbox'); ?>
	</div>
<? endif; ?>