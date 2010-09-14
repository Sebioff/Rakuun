<? $user = Rakuun_User_Manager::getCurrentUser(); ?>

<? if ($this->hasPanel('fight_tick')): ?>
	<? $this->displayPanel('fight_tick') ?>
	<br />
<? endif; ?>

<? if ($this->hasPanel('unread_messages')): ?>
	<? $this->displayPanel('unread_messages') ?>
	<br />
<? endif; ?>

<? if ($this->hasPanel('unread_tickets_users')): ?>
	<? $this->displayPanel('unread_tickets_users') ?>
	<br />
<? endif; ?>

<? if ($this->hasPanel('unread_tickets_supporters')): ?>
	<? $this->displayPanel('unread_tickets_supporters') ?>
	<br />
<? endif; ?>

<? if ($this->hasPanel('news')): ?>
	<? $this->displayPanel('news') ?>
	<br />
<? endif; ?>

<? if ($user->activationTime == 0 && !Rakuun_User_Manager::isSitting()): ?>
	Dein Account wurde noch nicht aktiviert. Falls der Account 3 Tage
	nach Anmeldung nicht aktiviert ist, wird er automatisch gelöscht. Wende dich an den <a href="<?= App::get()->getInternModule()->getSubmodule('messages')->getURL(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS)); ?>"><u>Support</u></a>, falls
	du nach 24 Stunden noch keine Aktivierungsmail erhalten hast.
	<br />
<? endif; ?>

<? $this->displayPanel('end') ?>

<? if ($this->hasPanel('dancertia_countdown')): ?>
	<? $this->displayPanel('dancertia_countdown') ?>
	<br />
<? endif; ?>

<? if ($this->hasPanel('specials')): ?>
	<br class="clear" />
	<? $this->displayPanel('specials'); ?>
<? endif; ?>

<? $this->hasPanel('wip_buildings') ? $this->displayPanel('wip_buildings') : '' ?>
<? $this->hasPanel('wip_technologies') ? $this->displayPanel('wip_technologies') : '' ?>
<? $this->hasPanel('wip_units') ? $this->displayPanel('wip_units') : '' ?>
<br class="clear" />

<? if ($this->hasPanel('incomming_armies')): ?>
	<? $this->displayPanel('incomming_armies') ?>
	<br class="clear" />
<? endif; ?>

<? if ($this->hasPanel('outgoing_armies')): ?>
	<? $this->displayPanel('outgoing_armies') ?>
	<br class="clear" />
<? endif; ?>

<div id="ctn_cityitems">
	<? $this->displayPanel('buildings') ?>
	<? $this->displayPanel('technologies') ?>
	<? $this->displayPanel('units') ?>
	
	<a href="http://www.galaxy-news.de/?page=charts&amp;op=vote&amp;game_id=67" target="_blank"><img src="http://www.galaxy-news.de/images/vote.gif" border="0" alt="Voten!" /></a>
	<br/>
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

<div id="ctn_info">
	<? $this->displayPanel('info'); ?>
	
	<? if ($this->hasPanel('sitterbox')): ?>
		<br class="clear" />
		<? $this->displayPanel('sitterbox'); ?>
	<? endif; ?>
	
	<? if ($this->hasPanel('sitterswitch')): ?>
		<br class="clear" />
		<? $this->displayPanel('sitterswitch'); ?>
	<? endif; ?>
</div>

<? if ($this->hasPanel('sbbox')): ?>
	<? $this->displayPanel('sbbox'); ?>
	<br class="clear" />
<? endif; ?>