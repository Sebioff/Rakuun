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
<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<div class="body">
		<div class="head">
			<? if ($this->getTitle()): ?>
				<div class="head_inner">
					<h2><?= $this->getTitle(); ?></h2>
				</div>
			<? endif; ?>
		</div>
		<div class="content">
			<div class="content_inner">
				<? $this->contentPanel->display(); ?>
			</div>
		</div>
	</div>
	<div class="border_decorator decorator1"></div>
	<div class="border_decorator decorator2"></div>
	<div class="border_decorator decorator3"></div>
	<div class="border_decorator decorator4"></div>
	<div class="corner topleft"></div>
	<div class="corner bottomleft"></div>
	<div class="corner topright"></div>
	<div class="corner bottomright"></div>
</div>