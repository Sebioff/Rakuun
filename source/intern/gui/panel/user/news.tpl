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
<? if ($this->hasPanel('unread_messages')): ?>
	<div class="text_icon_envelope">
		<? $this->displayPanel('unread_messages'); ?>
	</div>
<? endif; ?>

<? if ($this->hasPanel('unread_tickets_users')): ?>
	<div class="text_icon_envelope">
		<? $this->displayPanel('unread_tickets_users'); ?>
	</div>
<? endif; ?>

<? if ($this->hasPanel('unread_tickets_supporters')): ?>
	<div class="text_icon_envelope">
		<? $this->displayPanel('unread_tickets_supporters'); ?>
	</div>
<? endif; ?>

<? if ($this->hasPanel('unread_global_board_posts')): ?>
	<div class="text_icon_board">
		<? $this->displayPanel('unread_global_board_posts'); ?>
	</div>
<? endif; ?>

<? if ($this->hasPanel('unread_alliance_board_posts')): ?>
	<div class="text_icon_board">
		<? $this->displayPanel('unread_alliance_board_posts'); ?>
	</div>
<? endif; ?>

<? if ($this->hasPanel('unread_meta_board_posts')): ?>
	<div class="text_icon_board">
		<? $this->displayPanel('unread_meta_board_posts'); ?>
	</div>
<? endif; ?>

<? if ($this->hasPanel('unread_admin_board_posts')): ?>
	<div class="text_icon_board">
		<? $this->displayPanel('unread_admin_board_posts'); ?>
	</div>
<? endif; ?>

<? if ($this->hasPanel('news')): ?>
	<? $this->displayPanel('news') ?>
	<br />
<? endif; ?>

<? if (Rakuun_User_Manager::getCurrentUser()->activationTime == 0 && !Rakuun_User_Manager::isSitting()): ?>
	Dein Account wurde noch nicht aktiviert. Falls der Account 3 Tage
	nach Anmeldung nicht aktiviert ist, wird er automatisch gesperrt. Wende dich an den <a href="<?= App::get()->getInternModule()->getSubmodule('messages')->getURL(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS)); ?>"><u>Support</u></a>, falls
	du nach 24 Stunden noch keine Aktivierungsmail erhalten hast.
	<br />
<? endif; ?>

<? $voteUser = Rakuun_User_Manager::getCurrentUser(); ?>
<? if (Rakuun_User_Manager::isSitting()): ?>
	<? $voteUser = $voteUser->sitter; ?>
<? endif; ?>
<? if ($voteUser->lastGnVoting < time() - Rakuun_Intern_Module_GNVote::GN_VOTE_TIMELIMIT): ?>
	<div id="ctn_ad_buttons">
		<a href="<?= App::get()->getInternModule()->getSubmodule('vote')->getURL(); ?>" data-style="horizontal-counter" data-id="67" class="mmofacts-widget gnews_link" target="_blank">
			<img src="<?= Router::get()->getStaticRoute('images', 'vote.gif'); ?>" border="0" alt="Vote bitte für uns!" />
		</a>
		<script type="text/javascript" src="http://www.mmofacts.com/static/js/widget.js"></script>
	</div>
<? endif; ?>