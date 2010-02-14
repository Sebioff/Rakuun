<? $user = Rakuun_User_Manager::getCurrentUser(); ?>

Dies ist eine Testversion, in der noch einige Funktionen fehlen und die	insbesondere nicht so aussieht wie die fertige Version aussehen soll.
<br />
Falls Fehler auftreten gibt es keine Erstattungen. Probleme bitte <a href="http://tickets.rakuun.de" target="_blank"><u>hier</u></a> melden
<? if (App::get()->getInternModule()->hasSubmodule('messages')): ?>
(oder dem <a href="<?= App::get()->getInternModule()->getSubmodule('messages')->getURL(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS)); ?>"><u>Support</u></a>)
<? endif; ?>
.
<br />
<br />

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

<? if ($user->activationTime == 0): ?>
	<? // TODO add link to support ?>
	Dein Account wurde noch nicht aktiviert. Falls der Account 3 Tage
	nach Anmeldung nicht aktiviert ist, wird er automatisch gelöscht. Wende dich an den Support, falls
	du nach 24 Stunden noch keine Aktivierungsmail erhalten hast.
	<br />
<? endif; ?>

<? if ($this->hasPanel('dancertia_countdown')): ?>
	<? $this->displayPanel('dancertia_countdown') ?>
	<br />
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
	<!-- Beginning of Project Wonderful ad code: -->
	<!-- Ad box ID: 42688 -->
	<script type="text/javascript">
	<!--
	var pw_d=document;
	pw_d.projectwonderful_adbox_id = "42688";
	pw_d.projectwonderful_adbox_type = "4";
	pw_d.projectwonderful_foreground_color = "";
	pw_d.projectwonderful_background_color = "";
	//-->
	</script>
	<script type="text/javascript" src="http://www.projectwonderful.com/ad_display.js"></script>
	<noscript><map name="admap42688" id="admap42688"><area href="http://www.projectwonderful.com/out_nojs.php?r=0&amp;c=0&amp;id=42688&amp;type=4" shape="rect" coords="0,0,125,125" title="" alt="" target="_blank" /></map>
	<table cellpadding="0" border="0" cellspacing="0" width="125" bgcolor="#000000"><tr><td><img src="http://www.projectwonderful.com/nojs.php?id=42688&amp;type=4" width="125" height="125" usemap="#admap42688" border="0" alt="" /></td></tr><tr><td bgcolor="#000000" colspan="1"><center><a style="font-size:10px;color:#FFFFFF;text-decoration:none;line-height:1.2;font-weight:bold;font-family:Tahoma, verdana,arial,helvetica,sans-serif;text-transform: none;letter-spacing:normal;text-shadow:none;white-space:normal;word-spacing:normal;" href="http://www.projectwonderful.com/advertisehere.php?id=42688&amp;type=4" target="_blank">Your ad could be here, right now.</a></center></td></tr></table>
	</noscript>
	<!-- End of Project Wonderful ad code. -->
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