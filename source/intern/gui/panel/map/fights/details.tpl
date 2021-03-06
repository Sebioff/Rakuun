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
<? $this->displayPanel('text'); ?> in <? $this->displayPanel('countdown'); ?>
<hr/>
<h3>Einheiten</h3>
<ul>
	<? $attackSequence = array_reverse(explode('|', $this->getArmy()->fightingSequence)); ?>
	<? foreach (Rakuun_Intern_Production_Factory::getAllUnits($this->getArmy(), $attackSequence) as $unit): ?>
		<? if ($unit->getAmount() > 0): ?>
			<li>
				<?= Text::formatNumber($unit->getAmount()); ?>
				<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $unit->getType(), 'id' => $unit->getInternalName())); ?>">
					<?= $unit->getNameForAmount(); ?>
				</a>
			</li>
		<? endif; ?>
	<? endforeach; ?>
</ul>
<? if ($this->getTarget() != Rakuun_Intern_GUI_Panel_Map_Fights_Details::TARGET_HOME): ?>
	<br/>
	<? $attackForce = 0; ?>
	<? foreach (Rakuun_Intern_Production_Factory::getAllUnits($this->getArmy()) as $unit): ?>
		<? $attackForce += $unit->getAttackValue(); ?>
	<? endforeach; ?>
	Angriffskraft: <?= Text::formatNumber($attackForce); ?>
	<? if ($this->getArmy()->destroyBuildings): ?>
		<br/>
		Gebäude zerstören aktiviert
	<? endif; ?>
<? endif; ?>
<? if ($this->getTarget() == Rakuun_Intern_GUI_Panel_Map_Fights_Details::TARGET_HOME): ?>
	<hr/>
	<h3>Erbeutete Ressourcen</h3>
	<ul>
		<li>Eisen: <?= Text::formatNumber($this->getArmy()->iron); ?></li>
		<li>Beryllium: <?= Text::formatNumber($this->getArmy()->beryllium); ?></li>
		<li>Energie: <?= Text::formatNumber($this->getArmy()->energy); ?></li>
	</ul>
<? endif; ?>
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