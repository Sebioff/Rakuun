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

<? if (Rakuun_User_Manager::getCurrentUser()->activationTime == 0 && !Rakuun_User_Manager::isSitting()): ?>
	Dein Account wurde noch nicht aktiviert. Falls der Account 3 Tage
	nach Anmeldung nicht aktiviert ist, wird er automatisch gelöscht. Wende dich an den <a href="<?= App::get()->getInternModule()->getSubmodule('messages')->getURL(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS)); ?>"><u>Support</u></a>, falls
	du nach 24 Stunden noch keine Aktivierungsmail erhalten hast.
	<br />
<? endif; ?>