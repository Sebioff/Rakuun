<? /* @var $productionItem Rakuun_Intern_Production_Base */ ?>
<? $productionItem = $this->getProductionItem() ?>
<div class="production_item_header">
	<h2>
		<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $productionItem->getType(), 'id' => $productionItem->getInternalName())); ?>">
			<?= $productionItem->getName() ?>
		</a>
	</h2> (Stufe <?= $productionItem->getLevel() ?><?= ($productionItem->getFutureLevels() > 0) ? ' + '.$productionItem->getFutureLevels() : '' ?><?= ($productionItem->getMaximumLevel() > 0) ? ' / '.$productionItem->getMaximumLevel() : '' ?>)
</div>
<div class="production_item_actions">
	<? if (!$productionItem->reachedMaximumLevel()): ?>
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
					<a href="<?= App::get()->getInternModule()->getSubmodule('techtree')->getUrl(); ?>#<?= $productionItem->getInternalName(); ?>">Fehlende Voraussetzungen.</a>
				<? endif; ?>
			</span>
		<? endif; ?>
	<? else: ?>
		Maximalstufe erreicht.
	<? endif; ?>
	<? if ($this->hasPanel('remove')): ?>
		<? $this->displayPanel('remove') ?>
	<? endif; ?>
</div>
<br class="clear" />
<? if ($this->getHeadPanels()): ?>
	<div class="headpanels">
		<? foreach ($this->getHeadPanels() as $panel): ?>
			<? $panel->display(); ?>
		<? endforeach; ?>
	</div>
<? endif; ?>
<? if (!$productionItem->reachedMaximumLevel()): ?>
	<br />
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
<? endif; ?>
<div class="rakuun_production_item_description">
	<a class="rakuun_production_item_description_toggle" href="#">
		Kurzbeschreibung anzeigen
	</a>
	<div class="rakuun_production_item_description_content">
		<?= $productionItem->getShortDescription() ?>
		<? if ($effects = $productionItem->getEffects()): ?>
			<br />
			<br />
			<h3>Effekte</h3>
			<ul>
				<? foreach($effects as $effect): ?>
					<li><?= $effect; ?></li>
				<? endforeach; ?>
			</ul>
		<? endif; ?>
	</div>
</div>