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
<div id="ctn_summary_pointlists">
	<? $this->displayPanel('buildingsbox'); ?>
	<? $this->displayPanel('technologiesbox'); ?>
	<? $this->displayPanel('unitsbox'); ?>
</div>
<br class="clear" />
<div id="ctn_summary_unitstats">
	<? $this->displayPanel('lostunits'); ?>
	<? $this->displayPanel('destroyedunits'); ?>
</div>
<br class="clear" />
<div id="ctn_summary_buildingstats">
	<? $this->displayPanel('lostbuildings'); ?>
	<? $this->displayPanel('destroyedbuildings'); ?>
</div>
<div id="ctn_summary_mixedstats">
	<? $this->displayPanel('buildingevents'); ?>
	<? $this->displayPanel('technologiesevents'); ?>
	<br class="clear" />
	<? $this->displayPanel('ressources'); ?>
	<? $this->displayPanel('fights'); ?>
</div>
