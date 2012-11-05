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
<span id="<?= $this->getID(); ?>" class="<?= $this->getClassString() ?>" title="Klick mich"><?= $this->getTitle() ?></span>
<div id="<?= $this->getID(); ?>_hover" class="core_gui_hoverinfo" style="display:none;">
	<dl>
		<? foreach ($this->params->links as $code => $link): ?>
			<dt><?= $code ?></dt>
			<dd><?= $link ?></dd>
		<? endforeach; ?>
		<? foreach ($this->params->smilies as $code => $link): ?>
			<dt><?= $code ?></dt>
			<dd><?= $link ?></dd>
		<? endforeach; ?>
	</dl>
</div>