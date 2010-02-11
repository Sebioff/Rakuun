<? /* @var $item Rakuun_Intern_Production_Base */ ?>
<? $item = $this->getProductionItem() ?>
<h2 id="<?= $item->getInternalName() ?>" class="<?= $item->meetsTechnicalRequirements() ? 'rakuun_requirements_met' : 'rakuun_requirements_failed' ?>">
	<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $item->getType(), 'id' => $item->getInternalName())); ?>"><?= $item->getName() ?></a>
</h2>
<? $neededBuildings = $item->getNeededBuildings(); ?>
<? $neededTechnologies = $item->getNeededTechnologies(); ?>
<? $neededRequirements = $item->getNeededRequirements(); ?>
<? if ($neededBuildings || $neededTechnologies || $neededRequirements): ?>
	<ul>
		<? foreach ($neededBuildings as $internalName => $neededLevel): ?>
			<? $building = Rakuun_Intern_Production_Factory::getBuilding($internalName); ?>
			<li class="<?= ($building->getLevel() >= $neededLevel) ? 'rakuun_requirements_met' : 'rakuun_requirements_failed' ?>">
				<a href="#<?= $building->getInternalName() ?>"><?= $building->getName() ?> (<?= $building->getLevel() ?> / <?= $neededLevel ?>)</a>
			</li>
		<? endforeach; ?>
		
		<? foreach ($neededTechnologies as $internalName => $neededLevel): ?>
			<? $technology = Rakuun_Intern_Production_Factory::getTechnology($internalName); ?>
			<li class="<?= ($technology->getLevel() >= $neededLevel) ? 'rakuun_requirements_met' : 'rakuun_requirements_failed' ?>">
				<a href="#<?= $technology->getInternalName() ?>"><?= $technology->getName() ?> (<?= $technology->getLevel() ?> / <?= $neededLevel ?>)</a>
			</li>
		<? endforeach; ?>
		
		<? foreach ($neededRequirements as $requirement): ?>
			<li class="<?= ($requirement->fulfilled()) ? 'rakuun_requirements_met' : 'rakuun_requirements_failed' ?>">
				<?= $requirement->getDescription() ?>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>