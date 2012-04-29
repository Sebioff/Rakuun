<? /* @var $unit Rakuun_Intern_Production_Unit */ ?>
<? $unit = $this->getProductionItem(); ?>
<? if (($imagePath = Router::get()->getStaticRoute('images', 'infopictures/'.$unit->getInternalName().'.jpg')) != '/'): ?>
	<div class="rakuun_infopicture">
		<? $size = getimagesize(PROJECT_PATH.'/www/images/infopictures/'.$unit->getInternalName().'.jpg'); ?>
		<img src="<?= $imagePath; ?>" <?= ($size[0] > 480) ? 'width="480"' : '' ?> alt="<?= $unit->getName(); ?>" />
	</div>
<? endif; ?>
<?= $unit->getLongDescription(); ?>
<br/>
<br/>
<? if ($this->getProductionItem()->getAttributes()): ?>
	<h3>Eigenschaften</h3>
	<ul>
		<? foreach ($this->getProductionItem()->getAttributes() as $attributeProperties): ?>
			<? if ($attributeProperties['value'] == true): ?>
				<li><?= $attributeProperties['description']; ?></li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
	<br/>
<? endif; ?>
Grundangriffskraft: <?= $unit->getBaseAttackValue(); ?>
<br/>
Grundverteidigungskraft: <?= $unit->getBaseDefenseValue(); ?>
<? if ($unit->getSpeed() > 0): ?>
	<br/>
	Geschwindigkeit: <?= Rakuun_Date::formatCountDown(1 + $unit->getSpeed()); ?> / Feld
<? endif; ?>
<? if ($unit->getRessourceTransportCapacity(1) > 0): ?>
	<br/>
	Transportkapazität: <?= Text::formatNumber($unit->getRessourceTransportCapacity(1)); ?>
<? endif; ?>
<br/>
<? if ($unit->getBaseAttackValue() > 0 || $unit->getBaseDefenseValue() > 0): ?>
	<br/>
	<? if ($unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER)): ?>
		Fußsoldat
		<br/>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_VEHICLE != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_VEHICLE > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_VEHICLE ?>% Kampfkraft gegen Fahrzeuge
			<br/>
		<? endif; ?>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_AIRCRAFT != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_AIRCRAFT > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_FOOTSOLDIER_VS_AIRCRAFT ?>% Kampfkraft gegen Flugeinheiten
			<br/>
		<? endif; ?>
	<? endif; ?>
	<? if ($unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE)): ?>
		Fahrzeug
		<br/>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_FOOTSOLDIER != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_FOOTSOLDIER > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_FOOTSOLDIER ?>% Kampfkraft gegen Fußsoldaten
			<br/>
		<? endif; ?>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_AIRCRAFT != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_AIRCRAFT > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_VEHICLE_VS_AIRCRAFT ?>% Kampfkraft gegen Flugeinheiten
			<br/>
		<? endif; ?>
	<? endif; ?>
	<? if ($unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT)): ?>
		Flugeinheit
		<br/>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_FOOTSOLDIER != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_FOOTSOLDIER > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_FOOTSOLDIER ?>% Kampfkraft gegen Fußsoldaten
			<br/>
		<? endif; ?>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_VEHICLE != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_VEHICLE > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_AIRCRAFT_VS_VEHICLE ?>% Kampfkraft gegen Fahrzeuge
			<br/>
		<? endif; ?>
	<? endif; ?>
	<? if ($unit->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY)): ?>
		Stationäre Einheit
		<br/>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_FOOTSOLDIER != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_FOOTSOLDIER > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_FOOTSOLDIER ?>% Kampfkraft gegen Fußsoldaten
			<br/>
		<? endif; ?>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_VEHICLE != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_VEHICLE > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_VEHICLE ?>% Kampfkraft gegen Fahrzeuge
			<br/>
		<? endif; ?>
		<? if (Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_AIRCRAFT != 0): ?>
			<?= ((Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_AIRCRAFT > 0) ? '+' : '') . Rakuun_Intern_Production_Unit::BONUS_PERCENT_STATIONARY_VS_AIRCRAFT ?>% Kampfkraft gegen Flugeinheiten
			<br/>
		<? endif; ?>
	<? endif; ?>
<? endif; ?>
<br/>
<h3>Kosten</h3>
<? $this->displayPanel('costs'); ?>