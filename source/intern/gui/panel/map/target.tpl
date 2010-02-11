<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif ?>
<? $this->displayLabelForPanel('target'); ?> <? $this->displayPanel('target'); ?>
<br class="clear" />
Koordinaten: <? $this->displayPanel('target_x'); ?>:<? $this->displayPanel('target_y'); ?>
<br class="clear" />
<? $this->displayPanel('unit_input'); ?>
<? if ($this->hasPanel('spydrone') || $this->hasPanel('cloaked_spydrone')): ?>
	<hr/>
	<h2>Spionage</h2>
	<? if ($this->hasPanel('spydrone')): ?>
		<? $this->displayLabelForPanel('spydrone'); ?> <? $this->displayPanel('spydrone'); ?>
		<br class="clear" />
	<? endif; ?>
	<? if ($this->hasPanel('cloaked_spydrone')): ?>
		<? $this->displayLabelForPanel('cloaked_spydrone'); ?> <? $this->displayPanel('cloaked_spydrone'); ?>
	<? endif; ?>
<? endif; ?>
<br class="clear" />
<? $this->displayPanel('iron_priority'); ?>
<br class="clear" />
<? $this->displayPanel('beryllium_priority'); ?>
<br class="clear" />
<? $this->displayPanel('energy_priority'); ?>
<br class="clear" />
<? $this->displayPanel('destroy_buildings_label'); ?> <? $this->displayPanel('destroy_buildings'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>
