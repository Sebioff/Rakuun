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
<? $this->displayLabelForPanel('round'); ?> <? $this->displayPanel('round'); ?>
<br class="clear"/>
<? $this->displayLabelForPanel('username'); ?> <? $this->displayPanel('username'); ?>
<br class="clear"/>
<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
<br class="clear"/>
<? $this->displayPanel('state'); ?>
<? if ($this->state->getValue() == Rakuun_Intern_GUI_Panel_Profile_EternalProfile::STATE_CONFIRM): ?>
	Die Leistungen aus dieser Runde wurden bereits einem anderen ewigen Profil hinzugefügt.
	<br/>
	Willst du die Leistungen aus dem anderen ewigen Profil löschen und zu diesem hinzufügen?
	<br/>
<? endif; ?>
<? $this->displayPanel('add'); ?>
<? if ($this->params->linkedProfiles): ?>
	<hr/>
	<h3>Verbundene Profile</h3>
	<ul>
		<? foreach ($this->params->linkedProfiles as $linkedProfileName): ?>
			<li>
				<?= $linkedProfileName; ?>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>