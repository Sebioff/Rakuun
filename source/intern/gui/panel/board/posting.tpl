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
<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<div class="rakuun_board_postinfo">
		<? $this->displayPanel('user'); ?>, am <? $this->displayPanel('date'); ?>
		<? if ($this->hasPanel('editlink')): ?>
			<? $this->displayPanel('editlink'); ?>
		<? endif; ?>
		<? if ($this->hasPanel('delete')): ?>
			<? $this->displayPanel('delete'); ?>
		<? endif; ?>
		<br />
	</div>
	<div class="rakuun_board_postcontent">
		<? if ($this->params->posting->deleted == 1): ?>
			<? if ($this->params->config->getIsGlobal()): ?>
				<? if ($this->params->posting->deletedByRoundNumber == RAKUUN_ROUND_NAME): ?>
					<? $delUser = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->params->posting->deletedByName); ?>
					<? $delUserLink = new Rakuun_GUI_Control_UserLink('user', $delUser, $delUser->getPK()); ?>
				<? else: ?>
					<? $delUserLink = new GUI_Panel_Text('user', $this->params->posting->deletedByName.' ['.$this->params->posting->deletedByRoundNumber.']'); ?>
				<? endif; ?>
			<? else: ?>
				<? $delUserLink = new Rakuun_GUI_Control_Userlink('user', $this->params->posting->deletedBy, $this->params->posting->get('deleted_by')); ?>
			<? endif; ?>
		<i>
			Dieser Beitrag wurde von <? $delUserLink->display(); ?> gelöscht!<br />
			Er wird nur noch den Moderatoren und dem Autor angezeigt.<br />
		</i>
		<? endif; ?>
		<? if ($this->checkDisplayPosting()): ?>
			<? if ($this->hasPanel('form')): ?>
				<? $this->displayPanel('form'); ?>
			<? else: ?>
				<?= Rakuun_Text::formatPlayerText($this->params->posting->text); ?>
				<? if ($this->hasPanel('editdate')): ?>
				<br />
				<i>
					last edit:
					<? $this->displayPanel('editdate'); ?>
				</i>
				<? endif; ?>
			<? endif; ?>
		<? endif; ?>
	</div>
	<hr/>
</div>