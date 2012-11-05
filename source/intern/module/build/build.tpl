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
<? if (Rakuun_User_Manager::isSitting()): ?>
	<center>Herstellungskosten sind im Sittmodus um <?= (Rakuun_Intern_Production_Base::SITTER_PRODUCTION_COSTS_MULTIPLIER - 1) * 100; ?>% erhöht.</center>
<? endif; ?>
<? $this->displayPanel('wip'); ?>
<br class="clear" />
<? $this->displayPanel('sortpane'); ?>