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
<? $user = Rakuun_User_Manager::getCurrentUser(); ?>

<? if ($this->hasPanel('adminnews')): ?>
	<? $this->displayPanel('adminnews'); ?>
	<br />
<? endif; ?>

<? if ($this->hasPanel('dancertia_countdown')): ?>
	<? $this->displayPanel('dancertia_countdown'); ?>
	<br />
<? endif; ?>

<? $this->hasPanel('wip_buildings') ? $this->displayPanel('wip_buildings') : ''; ?>
<? $this->hasPanel('wip_units') ? $this->displayPanel('wip_units') : ''; ?>
<? $this->hasPanel('wip_technologies') ? $this->displayPanel('wip_technologies') : ''; ?>
<?= ($this->hasPanel('wip_buildings') || $this->hasPanel('wip_units') || $this->hasPanel('wip_technologies')) ? '<br class="clear" />' : ''; ?>


<? if ($this->hasPanel('fight_tick') && $this->hasPanel('incomming_armies') || $this->hasPanel('outgoing_armies')): ?>
	<? $this->displayPanel('fight_tick'); ?>
<? endif; ?>

<? if ($this->hasPanel('incomming_armies')): ?>
	<? $this->displayPanel('incomming_armies'); ?>
<? endif; ?>

<? if ($this->hasPanel('outgoing_armies')): ?>
	<? $this->displayPanel('outgoing_armies'); ?>
<? endif; ?>

<? if ($this->hasPanel('incomming_armies') || $this->hasPanel('outgoing_armies')): ?>
	<br class="clear"/>
<? endif; ?>

<div id="ctn_cityitems">
	<? $this->displayPanel('buildings'); ?>
	<? $this->displayPanel('technologies'); ?>
	<? $this->displayPanel('units'); ?>
	
	<div id="ctn_ad_buttons">
		<fb:like href="http://www.rakuun.de" layout="button_count" width="90"></fb:like><div id="fb-root"></div>
		<a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="RakuunBG">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
		<br class="clear"/>
		<? $voteUser = Rakuun_User_Manager::getCurrentUser(); ?>
		<? if (Rakuun_User_Manager::isSitting()): ?>
			<? $voteUser = $voteUser->sitter; ?>
		<? endif; ?>
		<? if ($voteUser->lastGnVoting > time() - Rakuun_Intern_Module_GNVote::GN_VOTE_TIMELIMIT): ?>
			<a href="<?= App::get()->getInternModule()->getSubmodule('vote')->getURL(); ?>" data-style="horizontal-counter" data-id="67" class="mmofacts-widget gnews_link" target="_blank">
				<img src="<?= Router::get()->getStaticRoute('images', 'vote_soon.gif'); ?>" border="0" alt="Danke fürs voten!" />
			</a>
			<script type="text/javascript" src="http://www.mmofacts.com/static/js/widget.js"></script>
		<? endif; ?>
		<br/>
		<script type="text/javascript"><!--
			google_ad_client = "pub-6454371224576770";
			/* 200x200, Erstellt 17.08.10 */
			google_ad_slot = "0237291473";
			google_ad_width = 200;
			google_ad_height = 200;
			//-->
		</script>
		<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>
</div>

<div id="ctn_info">
	<? if ($this->hasPanel('news')): ?>
		<? $this->displayPanel('news'); ?>
	<? endif; ?>

	<? if ($this->hasPanel('sitterbox')): ?>
		<? $this->displayPanel('sitterbox'); ?>
	<? endif; ?>
	
	<? if ($this->hasPanel('specials')): ?>
		<? $this->displayPanel('specials'); ?>
	<? endif; ?>
	
	<? $this->displayPanel('info'); ?>
	
	<? if ($this->hasPanel('sitterswitch')): ?>
		<br class="clear" />
		<? $this->displayPanel('sitterswitch'); ?>
	<? endif; ?>
</div>

<? if ($this->hasPanel('sbbox')): ?>
	<? $this->displayPanel('sbbox'); ?>
	<br class="clear" />
<? endif; ?>