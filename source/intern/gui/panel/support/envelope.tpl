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
<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?> onClick="window.location.href='<?= $this->params->url ?>'">
	<a href="<?= $this->params->url ?>">
		<? $this->displayLabelForPanel('user'); ?>: <? $this->displayPanel('user'); ?>
		<br/>
		Betreff: <?= Text::escapeHTML($this->getTicket()->subject); ?>
		<br/>
		<? $this->displayLabelForPanel('date'); ?>: <? $this->displayPanel('date'); ?>
	</a>
</div>