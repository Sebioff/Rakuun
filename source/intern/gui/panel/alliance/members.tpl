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
<? if($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if (!empty($this->params->members)): ?>
	<ul>
	<? foreach ($this->params->members as $member): ?>
		<li>
			<? $memberPanel = new Rakuun_GUI_Control_UserLink('member_'.$member->id, $member); ?>
			<? $memberPanel->display(); ?>
			<? $ranks = Rakuun_Intern_Alliance_Security::getForAlliance($this->getAlliance())->getUserGroups($member); ?>
			<? if (!empty($ranks)): ?>
				<? $rankNames = array(); ?>
				<? foreach ($ranks as $rank): ?>
					<? $rankNames[] = Text::escapeHTML($rank->name); ?>
				<? endforeach; ?>
				(<?= implode(', ', $rankNames); ?>)
			<? endif; ?>
		</li>
	<? endforeach; ?>
	<li>Anzahl: <?= count($this->params->members); ?></li>
	</ul>
<? endif; ?>