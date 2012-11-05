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
<? if ($this->params->shout->get('user') != Rakuun_Intern_GUI_Panel_Shoutbox::ANNOUNCER_USERID): ?>
	<div class="shout_header">
		<? $this->displayPanel('userlink'); ?>, am <? $this->displayPanel('date'); ?>
		<? if ($this->hasPanel('answerlink')): $this->displayPanel('answerlink'); endif; ?>
		<? if ($this->hasPanel('moderate')): ?>
			<? $this->displayPanel('moderate'); ?>
		<? endif; ?>
	</div>
<div class="shout_text">
<? else: ?>
	<div class="shout_text shout_announcement">
<? endif; ?>
	<?= Rakuun_Text::formatPlayerText($this->params->shout->text); ?>
</div>