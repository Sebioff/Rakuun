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
<div id="<?= $this->getID(); ?>" class="ctn_shoutbox">
	<? if ($this->hasErrors()): ?>
		<? $this->displayErrors(); ?>
	<? endif; ?>
	<? $this->displayPanel('refresh'); ?>
	<? if ($this->hasPanel('moderatelink')): ?>
		<? $this->displayPanel('moderatelink'); ?>
	<? endif; ?>
	<? $this->displayPanel('info'); ?>
	<hr />
	<? foreach ($this->panels as $panel): ?>
		<? if (strpos($panel->getName(), 'shout_') === 0): ?>
			<? $panel->display(); ?>
			<hr/>
		<? endif; ?>
	<? endforeach; ?>
	<? if ($this->getPageCount() > 1): ?>
		<? $this->displayLabelForPanel('pages', array('shoutbox_pages_label')); ?> <? $this->displayPanel('pages'); ?>
		<br class="clear"/>
		<hr />
	<? endif; ?>
	<? $this->displayPanel('shoutarea'); ?>
	<br class="clear" />
	<span style="float:left">Buchstaben übrig:</span> <input id="shoutbox_characters_left" type="text" size="3" value="<?= $this->config->getShoutMaxLength(); ?>" readonly="readonly" /><? $this->displayPanel('submit'); ?>
</div>