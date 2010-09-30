<div class="rakuun_map_target_panel">
	<? if ($this->hasErrors()): ?>
		<? $this->displayErrors(); ?>
	<? endif; ?>
	<? if ($this->state->getValue() == Rakuun_Intern_GUI_Panel_Map_Target::STATE_REVIEWING): ?>
		<? if (!($target = $this->getTargetUser())): ?>
			<? $target = $this->targetX->getValue().':'.$this->targetY->getValue(); ?>
		<? else: ?>
			<? if (Rakuun_User_Manager::getCurrentUser()->alliance && $target->alliance && Rakuun_User_Manager::getCurrentUser()->alliance->getPK() == $target->alliance->getPK()): ?>
				Achtung: du greifst ein Mitglied deiner Allianz an!
				<br/>
			<? endif; ?>
			<? $target = $target->name; ?>
		<? endif; ?>
		Ziel: <?= $target; ?>
		<br/>
		Dauer: <?= Rakuun_Date::formatCountDown($this->getArmy()->targetTime - time()); ?>
		<br/>
		voraussichtliche Ankunft: <? $date = new GUI_Panel_Date('arrivingtime', $this->getArmy()->targetTime, '', GUI_Panel_Date::FORMAT_TIME); $date->display(); ?>
	<? else: ?>
		<? $this->displayLabelForPanel('target'); ?> <? $this->displayPanel('target'); ?>
		<br class="clear" />
		<? $this->displayPanel('target_coords_label'); ?> <? $this->displayPanel('target_x'); ?><? $this->displayPanel('target_y'); ?>
	<? endif; ?>
	<br class="clear" />
	<hr />
	<? $this->displayPanel('unit_input'); ?>
	<? if ($this->hasPanel('spydrone') || $this->hasPanel('cloaked_spydrone')): ?>
		<h2>Spionage</h2> 
		<? if ($this->hasPanel('spydrone')): ?>
			<? $this->displayLabelForPanel('spydrone'); ?> <? $this->displayPanel('spydrone'); ?>
			<br class="clear" />
		<? endif; ?>
		<? if ($this->hasPanel('cloaked_spydrone')): ?>
			<? $this->displayLabelForPanel('cloaked_spydrone'); ?> <? $this->displayPanel('cloaked_spydrone'); ?>
			<br class="clear" />
		<? endif; ?>
		<? $this->displayPanel('spy_label'); ?>
		<hr/>
	<? endif; ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('iron_priority'); ?> <? $this->displayPanel('iron_priority'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('beryllium_priority'); ?> <? $this->displayPanel('beryllium_priority'); ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('energy_priority'); ?> <? $this->displayPanel('energy_priority'); ?>
	<br class="clear" />
	<? $this->displayPanel('destroy_buildings_label'); ?> <? $this->displayPanel('destroy_buildings'); ?>
	<br class="clear" />
	<? $this->displayPanel('state'); ?>
	<? $this->displayPanel('submit'); ?>
</div>
