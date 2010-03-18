<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div id="warsim_panels">
	<div id="warsim_panels_units">
		<h1>Einheiten</h1>
		<div class="warsim_panels_attacker">
			<h1>Angreifer</h1>
			<? foreach ($this->getPanelsForAttackers() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
		</div>
		<div class="warsim_panels_defender">
			<h1>Verteidiger</h1>
			<? foreach ($this->getPanelsForDefenders() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
		</div>
	</div>
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
	<div id="warsim_panels_buildings">
		<h1>Gebäude</h1>
		<div class="warsim_panels_defender">
			<h1>Verteidiger</h1>
			<? foreach ($this->getPanelsForDefendersBuildings() as $panel): ?>
				<? $this->displayLabelForPanel($panel->getName()); ?> <? $panel->display(); ?>
				<br class="clear" />
			<? endforeach; ?>
		</div>
	</div>
</div>
<br />
<? $this->displayPanel('calcwarsim'); ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors()): ?>
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
	<h1>Angreifer (<?= $this->getFightingSystem()->getTotalAttackingPower(); ?>)</h1>
	<? foreach ($this->getFightingSystem()->getAttackingPowerByUnits() as $unitName => $attackingPower): ?>
		<? $unit = Rakuun_Intern_Production_Factory::getUnit($unitName, $this->getFightingSystem()->getAttackerUnitSource()); ?>
		<?= $unit->getAmount() ?> <?= $unit->getNameForAmount() ?> (<?= $attackingPower; ?>)
		<br />
	<? endforeach; ?>
	<br/>
	<h1>Verteidiger (<?= $this->getFightingSystem()->getTotalDefendingPower(); ?>)</h1>
	<? foreach ($this->getFightingSystem()->getDefendingPowerByUnits() as $unitName => $defendingPower): ?>
		<? $unit = Rakuun_Intern_Production_Factory::getUnit($unitName, $this->getFightingSystem()->getDefenderUnitSource()); ?>
		<?= $unit->getAmount() ?> <?= $unit->getNameForAmount() ?> (<?= $defendingPower; ?>)
		<br />
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