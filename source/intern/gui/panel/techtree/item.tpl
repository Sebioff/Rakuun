<?
/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */
?>
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