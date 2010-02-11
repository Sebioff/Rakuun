<? /* @var $productionItem Rakuun_Intern_Production_Base */ ?>
<? $productionItem = $this->getProductionItem() ?>
<h2>
	<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $productionItem->getType(), 'id' => $productionItem->getInternalName())); ?>">
		<?= $productionItem->getName() ?>
	</a>
</h2> (Stufe <?= $productionItem->getLevel() ?><?= ($productionItem->getFutureLevels() > 0) ? ' + '.$productionItem->getFutureLevels() : '' ?>)
<div class="headpanels">
	<? foreach ($this->getHeadPanels() as $panel): ?>
		<? $panel->display(); ?>
	<? endforeach; ?>
</div>
<br />
<?= $productionItem->getShortDescription() ?>
<br />
<br />
<? if ($effects = $productionItem->getEffects()): ?>
	<h3>Effekte</h3>
	<ul>
		<? foreach($effects as $effect): ?>
			<li><?= $effect; ?></li>
		<? endforeach; ?>
	</ul>
	<br />
	<br />
<? endif; ?>
<? if (!$productionItem->reachedMaximumLevel()): ?>
	<? $nextBuildableLevel = $productionItem->getNextBuildableLevel() ?>
	<? $ressources = $productionItem->getUser()->ressources ?>
	<? $ironCosts = $productionItem->getIronCostsForLevel($nextBuildableLevel); ?>
	<? if ($ironCosts > 0): ?>
		<? $classes = array('rakuun_ressource', 'rakuun_ressource_iron'); ?>
		<? if ($ironCosts > $ressources->iron): ?>
			<? $classes[] = 'rakuun_requirements_failed'; ?>
		<? endif; ?>
		<span class="<?= implode(' ', $classes) ?>"><?= GUI_Panel_Number::formatNumber($ironCosts); ?> Eisen</span>
	<? endif; ?>
	<? $berylliumCosts = $productionItem->getBerylliumCostsForLevel($nextBuildableLevel); ?>
	<? if ($berylliumCosts > 0): ?>
		<? $classes = array('rakuun_ressource', 'rakuun_ressource_beryllium'); ?>
		<? if ($berylliumCosts > $ressources->beryllium): ?>
			<? $classes[] = 'rakuun_requirements_failed'; ?>
		<? endif; ?>
		<span class="<?= implode(' ', $classes) ?>"><?= GUI_Panel_Number::formatNumber($berylliumCosts); ?> Beryllium</span>
	<? endif; ?>
	<? $energyCosts = $productionItem->getEnergyCostsForLevel($nextBuildableLevel); ?>
	<? if ($energyCosts > 0): ?>
		<? $classes = array('rakuun_ressource', 'rakuun_ressource_energy'); ?>
		<? if ($energyCosts > $ressources->energy): ?>
			<? $classes[] = 'rakuun_requirements_failed'; ?>
		<? endif; ?>
		<span class="<?= implode(' ', $classes) ?>"><?= GUI_Panel_Number::formatNumber($energyCosts); ?> Energie</span>
	<? endif; ?>
	<? $peopleCosts = $productionItem->getPeopleCostsForLevel($nextBuildableLevel); ?>
	<? if ($peopleCosts > 0): ?>
		<? $classes = array('rakuun_ressource', 'rakuun_ressource_people'); ?>
		<? if ($peopleCosts > $ressources->people): ?>
			<? $classes[] = 'rakuun_requirements_failed'; ?>
		<? endif ?>
		<span class="<?= implode(' ', $classes) ?>"><?= GUI_Panel_Number::formatNumber($peopleCosts); ?> Leute</span>
	<? endif ?>
	<?= Rakuun_Date::formatCountDown($productionItem->getTimeCosts($nextBuildableLevel)) ?>
	<br />
	<? if ($productionItem->canBuild()): ?>
		<? if ($this->hasErrors()): ?>
			<? $this->displayErrors(); ?>
		<? endif; ?>
		<? if ($this->hasPanel('produce')): ?>
			<? $this->displayPanel('produce') ?>
		<? endif; ?>
	<? else: ?>
		<span class="rakuun_requirements_failed">
			<? if (!$productionItem->gotEnoughRessources()): ?>
				Unzureichende Rohstoffe.
			<? else: ?>
				Fehlende Voraussetzungen.
			<? endif; ?>
		</span>
	<? endif; ?>
<? else: ?>
	Maximalstufe erreicht.
<? endif; ?>
<? if ($this->hasPanel('remove')): ?>
	<? $this->displayPanel('remove') ?>
<? endif; ?>