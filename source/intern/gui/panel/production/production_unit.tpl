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
<? /* @var $productionItem Rakuun_Intern_Production_Unit */ ?>
<? $productionItem = $this->getProductionItem(); ?>
<div class="production_item_header clearfix">
	<div class="production_item_title head_inner">
		<h2>
			<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $productionItem->getType(), 'id' => $productionItem->getInternalName())); ?>">
				<?= $productionItem->getName(); ?>
			</a>
		</h2> (<?= Text::formatNumber($productionItem->getAmount()); ?><?= ($productionItem->getAmountInProduction() > 0) ? ' + '.Text::formatNumber($productionItem->getAmountInProduction()) : '' ?>)
	</div>
	<div class="production_item_actions">
		<? if ($productionItem->canBuild()): ?>
			<? if ($this->hasErrors()): ?>
				<? $this->displayErrors(); ?>
			<? endif; ?>
			<? if ($this->hasPanel('produce')): ?>
				<? $this->displayPanel('amount') ?>
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
		<? endif ?>
	</div>
</div>
<? $ressources = $productionItem->getUser()->ressources; ?>
<? $ironCosts = $productionItem->getIronCostsForAmount(1); ?>
<? if ($ironCosts > 0): ?>
	<? $classes = array('rakuun_ressource', 'rakuun_ressource_iron'); ?>
	<? if ($ironCosts > $ressources->iron): ?>
		<? $classes[] = 'rakuun_requirements_failed'; ?>
	<? endif ?>
	<span class="<?= implode(' ', $classes); ?>"><?= Text::formatNumber($ironCosts); ?> Eisen</span>
<? endif ?>
<? $berylliumCosts = $productionItem->getBerylliumCostsForAmount(1); ?>
<? if ($berylliumCosts > 0): ?>
	<? $classes = array('rakuun_ressource', 'rakuun_ressource_beryllium'); ?>
	<? if ($berylliumCosts > $ressources->beryllium): ?>
		<? $classes[] = 'rakuun_requirements_failed'; ?>
	<? endif ?>
	<span class="<?= implode(' ', $classes); ?>"><?= Text::formatNumber($berylliumCosts); ?> Beryllium</span>
<? endif ?>
<? $energyCosts = $productionItem->getEnergyCostsForAmount(1); ?>
<? if ($energyCosts > 0): ?>
	<? $classes = array('rakuun_ressource', 'rakuun_ressource_energy'); ?>
	<? if ($energyCosts > $ressources->energy): ?>
		<? $classes[] = 'rakuun_requirements_failed'; ?>
	<? endif ?>
	<span class="<?= implode(' ', $classes); ?>"><?= Text::formatNumber($energyCosts); ?> Energie</span>
<? endif ?>
<? $peopleCosts = $productionItem->getPeopleCostsForAmount(1); ?>
<? if ($peopleCosts > 0): ?>
	<? $classes = array('rakuun_ressource', 'rakuun_ressource_people'); ?>
	<? if ($peopleCosts > $ressources->people): ?>
		<? $classes[] = 'rakuun_requirements_failed'; ?>
	<? endif ?>
	<span class="<?= implode(' ', $classes); ?>"><?= Text::formatNumber($peopleCosts); ?> Leute</span>
<? endif ?>
<?= Rakuun_Date::formatCountDown($productionItem->getTimeCosts(1)); ?>
<div class="rakuun_production_item_description">
	<a class="rakuun_production_item_description_toggle" href="#">
		Kurzbeschreibung anzeigen
	</a>
	<div class="rakuun_production_item_description_content">
		<? if ($productionItem->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER)): ?>
			Fußsoldat
			<br/>
		<? endif; ?>
		<? if ($productionItem->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE)): ?>
			Fahrzeug
			<br/>
		<? endif; ?>
		<? if ($productionItem->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT)): ?>
			Flugeinheit
			<br/>
		<? endif; ?>
		<? if ($productionItem->isOfUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY)): ?>
			Stationäre Einheit
			<br/>
		<? endif; ?>
		<br/>
		Angriffskraft: <?= $productionItem->getAttackValue(1); ?> | Verteidigungskraft: <?= $productionItem->getDefenseValue(1); ?>
		<br/>
		<?= $productionItem->getShortDescription(); ?>
	</div>
</div>
