<? $this->displayPanel('text'); ?> in <? $this->displayPanel('countdown'); ?>
<hr/>
<h3>Einheiten</h3>
<ul>
	<? foreach (Rakuun_Intern_Production_Factory::getAllUnits($this->getArmy()) as $unit): ?>
		<? if ($unit->getAmount() > 0): ?>
			<li>
				<?= $unit->getAmount(); ?>
				<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $unit->getType(), 'id' => $unit->getInternalName())); ?>">
					<?= $unit->getNameForAmount(); ?>
				</a>
			</li>
		<? endif; ?>
	<? endforeach; ?>
</ul>
<hr/>
<h3>Technologiestand</h3>
<ul>
	<? foreach (Rakuun_Intern_Production_Factory::getAllTechnologies($this->getArmy()->technologies) as $technology): ?>
		<? if ($technology->getLevel() > 0): ?>
			<li>
				<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $technology->getType(), 'id' => $technology->getInternalName())); ?>">
					<?= $technology->getName(); ?>
				</a>
				(Stufe <?= $technology->getLevel(); ?>)
			</li>
		<? endif; ?>
	<? endforeach; ?>
</ul>