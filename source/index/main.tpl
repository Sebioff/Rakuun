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
<div id="ctn_index" class="<?= Rakuun_GUI_Skinmanager::get()->getCurrentSkinClass() ?>">
	<div id="ctn_navigation">
		<? $this->params->navigation->display() ?>
	</div>
	<div id="ctn_content">
		<? $this->displayPage(); ?>
		<? $bgImage = Router::get()->getStaticRoute('images', 'background_index.jpg'); ?>
		<? $easterSunday = easter_date(); ?>
		<? $date = date('d.m'); ?>
		<? if ($date == date('d.m', $easterSunday - 60 * 60 * 24 * 2) || $date == date('d.m', $easterSunday - 60 * 60 * 24) || $date == date('d.m', $easterSunday) || $date == date('d.m', $easterSunday + 60 * 60 * 24)): ?>
			<? $bgImage = Router::get()->getStaticRoute('images', 'seasons/background_index_easter.png'); ?>
		<? endif; ?>
		<? if (date('n') == 2 && (date('j') == 15 || date('Y') == 2012)): ?>
			<? $bgImage = Router::get()->getStaticRoute('images', 'seasons/background_index_ooo.png'); ?>
		<? endif; ?>
		<img class="background_image" alt="Rakuun" src="<?= $bgImage; ?>"/>
	</div>
</div>