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
<?= $this->getProductionItem()->getLongDescription(); ?>
<br/>
<br/>
<? if ($this->getProductionItem()->getEffects()): ?>
	<h3>Effekte</h3>
	<ul>
		<? foreach ($this->getProductionItem()->getEffects() as $effect): ?>
			<li><?= $effect; ?></li>
		<? endforeach; ?>
	</ul>
	<br/>
<? endif; ?>
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
Punkte / Stufe: <?= $this->getProductionItem()->getPoints(); ?>
<br/>
<h3>Kosten</h3>
<? $this->displayPanel('costs'); ?>