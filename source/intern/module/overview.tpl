<? $user = Rakuun_User_Manager::getCurrentUser(); ?>

Dies ist eine Testversion, in der noch einige Funktionen fehlen und die	insbesondere nicht so aussieht wie die fertige Version aussehen soll.
<br />
Falls Fehler auftreten gibt es keine Erstattungen. Probleme bitte dem <a href="<?= App::get()->getInternModule()->getSubmodule('messages')->getURL(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS)); ?>"><u>Support</u></a> melden.
<br />
<br />

<? if ($this->hasPanel('unread_messages')): ?>
	<? $this->displayPanel('unread_messages') ?>
	<br />
<? endif; ?>

<? if ($this->hasPanel('unread_tickets')): ?>
	<? $this->displayPanel('unread_tickets') ?>
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
</div>

<? if ($this->hasPanel('sitterbox')): ?>
	<? $this->displayPanel('sitterbox'); ?>
<? endif; ?>

<? if ($this->hasPanel('sitterswitch')): ?>
	<? $this->displayPanel('sitterswitch'); ?>
<? endif; ?>

<? $this->displayPanel('info'); ?>

<? if ($this->hasPanel('sbbox')): ?>
	<? $this->displayPanel('sbbox'); ?>
<? endif; ?>