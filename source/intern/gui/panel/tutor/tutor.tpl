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
<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('detlef'); ?>
<div id="ctn_tutor_content">
	<?= $this->params->level->getDescription(); ?>
</div>
<div id="ctn_tutor_controls">
	Schritt <?= $this->getCurrentLevelNumber(); ?> von <?= $this->getLevelCount(); ?> -
	<? if ($this->params->level->completed()): ?>
		<span class="rakuun_requirements_met">Erledigt</span>
	<? else: ?>
		<span class="rakuun_requirements_failed">Nicht erledigt</span>
	<? endif; ?>
	<? if ($this->hasPanel('first')): ?>
		<? $this->displayPanel('first'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('back')): ?>
		<? $this->displayPanel('back'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('next')): ?>
		<? $this->displayPanel('next'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('last')): ?>
		<? $this->displayPanel('last'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('end')): ?>
		<? $this->displayPanel('end'); ?>
	<? endif; ?>
</div>
<br class="clear" />