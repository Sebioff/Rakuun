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
<? $this->displayLabelForPanel('create_news'); ?> <? $this->displayPanel('create_news'); ?>
<? if ($this->hasPanel('newstext')): ?>
	<br class="clear"/>
	<? $this->displayLabelForPanel('newstext'); ?> <? $this->displayPanel('newstext'); ?>
	<br class="clear"/>
	<? $this->displayLabelForPanel('tweet'); ?> <? $this->displayPanel('tweet'); ?>
	<br class="clear"/>
	<span style="float:left">Buchstaben übrig:</span> <input id="shoutbox_characters_left" type="text" size="3" value="140" readonly="readonly" />
<? elseif($this->state->getValue() == Rakuun_Intern_GUI_Panel_Admin_Update::STATE_REVIEWING): ?>
	<br class="clear"/>
	Es wird kein Newseintrag erstellt.
<? endif; ?>
<? $this->displayPanel('update'); ?>
<br />
<? if (isset($this->params->conflicts) && $this->params->conflicts): ?>
	<span style="color:#ff0000; font-weight:bold">Es gab Konflikte beim Updaten!</span>
	<br/>
<? endif; ?>
<? $this->displayPanel('update_log'); ?>
<? $this->displayPanel('state'); ?>
<br class="clear"/>