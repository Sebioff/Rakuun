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
<div id="ctn_main">
	<div id="ctn_ingame" class="module_<?= Router::get()->getCurrentModule()->getName(); ?>">
		<div id="ctn_head" class="clearfix">
			<div id="ctn_navigation">
				<? $this->params->navigation->display(); ?>
			</div>
			<div id="ctn_ressources">
				<span class="rakuun_ressource rakuun_ressource_iron"><? $this->displayLabelForPanel('iron'); ?> <? $this->displayPanel('iron'); ?></span>
				<br />
				<span class="rakuun_ressource rakuun_ressource_beryllium"><? $this->displayLabelForPanel('beryllium'); ?> <? $this->displayPanel('beryllium'); ?></span>
				<br />
				<span class="rakuun_ressource rakuun_ressource_energy"><? $this->displayLabelForPanel('energy'); ?> <? $this->displayPanel('energy'); ?></span>
				<br />
				<span class="rakuun_ressource rakuun_ressource_people"><? $this->displayLabelForPanel('people'); ?> <? $this->displayPanel('people'); ?></span>
			</div>
		</div>
		<div id="ctn_content" class="clearfix">
			<? if ($this->hasPanel('tutor')): ?>
				<? $this->displayPanel('tutor'); ?>
			<? endif; ?>
			<? $this->displayPage(); ?>
		</div>
		<div id="ctn_footer">
		</div>
	</div>
</div>