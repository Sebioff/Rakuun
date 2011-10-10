<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div id="warsim_panels">
	<div id="warsim_panels_units">
		<h1>Einheiten</h1>
		<br class="clear" />
		<div class="warsim_panels_attacker">
			<h1>Angreifer</h1>
			<? if ($this->hasPanel('use_own_for_att')): ?>
				<? $this->displayPanel('use_own_for_att'); ?>
			<? endif; ?>
			<br class="clear" />
			<? foreach ($this->getPanelsForAttackers() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
		</div>
		<div class="warsim_panels_defender">
			<h1>Verteidiger</h1>
			<? if ($this->hasPanel('use_own_for_deff')): ?>
				<? $this->displayPanel('use_own_for_deff'); ?>
			<? endif; ?>
			<br class="clear" />
			<? foreach ($this->getPanelsForDefenders() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
		</div>
	</div>
	<br class="clear"/>
	<div>
		<h1>Technologie</h1>
		<div class="warsim_panels_attacker">
			<h1>Angreifer</h1>
			<? foreach ($this->getPanelsForAttackersTechnology() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
		</div>
		<div class="warsim_panels_defender">
			<h1>Verteidiger</h1>
			<? foreach ($this->getPanelsForDefendersTechnology() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
		</div>
	</div>
	<br class="clear"/>
	<div id="warsim_panels_buildings">
		<h1>Gebäude</h1>
		<div class="warsim_panels_defender clearfix">
			<h1>Verteidiger</h1>
			<? foreach ($this->getPanelsForDefendersBuildings() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
			<? $this->displayPanel('calcwarsim'); ?>
		</div>
	</div>
	<br class="clear"/>
</div>
<? if ($this->calcwarsim->hasBeenSubmitted() && !$this->hasErrors()): ?>
	<br class="clear" />
	<hr/>
	<? if ($this->getFightingSystem()->getDefenderWon()): ?>
		Verteidiger gewinnt!
	<? else: ?>
		Angreifer gewinnt!
	<? endif; ?>
	<hr/>
	Überlebende Einheiten Angreifer:
	<br/>
	<? foreach ($this->getFightingSystem()->getSurvivingAttackingUnitAmounts() as $unitName => $unitAmount): ?>
		<? $unit = Rakuun_Intern_Production_Factory::getUnit($unitName); ?>
		<?= $unitAmount ?> <?= $unit->getNameForAmount($unitAmount); ?>
		<br />
	<? endforeach; ?>
	<hr/>
	Überlebende Einheiten Verteidiger:
	<br/>
	<? foreach ($this->getFightingSystem()->getSurvivingDefendingUnitAmounts() as $unitName => $unitAmount): ?>
		<? $unit = Rakuun_Intern_Production_Factory::getUnit($unitName); ?>
		<?= $unitAmount ?> <?= $unit->getNameForAmount($unitAmount); ?>
		<br />
	<? endforeach; ?>
	<hr/>
	<h1>Kampfkraft</h1>
	<br/>
	<h1>Angreifer (<?= Text::formatNumber($this->getFightingSystem()->getTotalAttackingPower()); ?>)</h1>
	<? foreach ($this->getFightingSystem()->getAttackingPowerByUnits() as $unitName => $attackingPower): ?>
		<? $unit = Rakuun_Intern_Production_Factory::getUnit($unitName, $this->getFightingSystem()->getAttackerUnitSource()); ?>
		<? if ($unit->getAmount() > 0): ?>
			<?= $unit->getAmount() ?> <?= $unit->getNameForAmount() ?> (<?= Text::formatNumber($attackingPower); ?>)
			<br />
		<? endif; ?>
	<? endforeach; ?>
	<br/>
	<h1>Verteidiger (<?= Text::formatNumber($this->getFightingSystem()->getTotalDefendingPower()); ?>)</h1>
	<? foreach ($this->getFightingSystem()->getDefendingPowerByUnits() as $unitName => $defendingPower): ?>
		<? $unit = Rakuun_Intern_Production_Factory::getUnit($unitName, $this->getFightingSystem()->getDefenderUnitSource()); ?>
		<? if ($unit->getAmount() > 0): ?>
			<?= $unit->getAmount() ?> <?= $unit->getNameForAmount() ?> (<?= Text::formatNumber($defendingPower); ?>)
			<br />
		<? endif; ?>
	<? endforeach; ?>
	<hr/>
	<h1>Boni</h1>
	Fuss vs Fahr <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_VEHICLE ?>%
	<br/>
	Fuss vs Flug <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_AIRCRAFT ?>%
	<br/>
	Fahr vs Fuss <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_FOOTSOLDIER ?>%
	<br/>
	Fahr vs Flug <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_AIRCRAFT ?>%
	<br/>
	Flug vs Fuss <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_FOOTSOLDIER ?>%
	<br/>
	Flug vs Fahr <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_VEHICLE ?>%
	<br/>
	Stationär vs Fuss <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_FOOTSOLDIER ?>%
	<br/>
	Stationär vs Fahr <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_VEHICLE ?>%
	<br/>
	Stationär vs Flug <?= Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_AIRCRAFT ?>%
<? endif; ?>