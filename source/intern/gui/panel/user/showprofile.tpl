<? // TODO don't forget to show more public Userdata if there are implemented ?>

<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $user = $this->getUser(); ?>
<? $currentUser = Rakuun_User_Manager::getCurrentUser(); ?>
<? if ($user): ?>
	<? if ($this->hasPanel('picture')): ?>
		<? $this->displayPanel('picture'); ?>
	<? endif; ?>
	<br class="clear" />
	Username: <?= $user->name; ?>
	<br class="clear" />
	Stadtname: <?= Text::escapeHTML($user->cityName); ?>
	<br class="clear" />
	Punkte: <?= GUI_Panel_Number::formatNumber((int)$user->points); ?>
	<? if ($user->alliance) : ?>
		<br class="clear" />
		Allianz:
		<? $allylink = new Rakuun_GUI_Control_AllianceLink('allylink', $user->alliance, $user->alliance->name); ?>
		<? $allylink->display(); ?>
	<? endif;?>
	<br class="clear" />
	Koordinaten:
	<? $mapLink = new Rakuun_GUI_Control_Maplink('maplink', $user, 'zur Karte'); ?>
	<? $mapLink->display(); ?>
	<br class="clear" />
	Beschreibung:
	<br class="clear" />
	<?= $user->description ?>
	<br class="clear" />
	Verwarnpunkte: <?= Rakuun_Intern_GUI_Panel_Admin_User_Caution::getCautionPoints($user) ?>
	<br class="clear" />
	<br class="clear" />
	Aktionen:
	<br class="clear" />
	<? $sendmessagelink = new Rakuun_GUI_Control_sendmessagelink('sendmessagelink', $user); ?>
	<? $sendmessagelink->display(); ?>
	<br class="clear" />
	<? if ($user->getPK() != $currentUser->getPK() && $user->buildings->moleculartransmitter > 0): ?>
		<? $tradePanel = new Rakuun_GUI_Control_TradeLink('tradelink', $user, 'Handeln'); ?>
		<? $tradePanel->display() ?>
		<br class="clear" />
	<? endif;?>
	<? if (Rakuun_TeamSecurity::get()->hasPrivilege($currentUser, Rakuun_TeamSecurity::PRIVILEGE_USERLOCK)) : ?>
		<? $userlock = new Rakuun_GUI_Control_UserLockLink('userlocklink', $user, 'User Sperren'); ?>
		<? $userlock->display() ?>
		<br class="clear" />
	<? endif;?>
	<? if (Rakuun_TeamSecurity::get()->hasPrivilege($currentUser, Rakuun_TeamSecurity::PRIVILEGE_USEREDIT)): ?>
		<? $useredit = new Rakuun_GUI_Control_UserEditLink('usereditlink', $user, 'User bearbeiten'); ?>
		<? $useredit->display() ?>
		<br class="clear" />
	<? endif;?>
	<? if (Rakuun_TeamSecurity::get()->hasPrivilege($currentUser, Rakuun_TeamSecurity::PRIVILEGE_CAUTION)): ?>
		<? $useredit = new Rakuun_GUI_Control_UserCautionLink('usercautionlink', $user, 'User verwarnen'); ?>
		<? $useredit->display() ?>
		<br class="clear" />
	<? endif;?>
	<? if (Rakuun_TeamSecurity::get()->hasPrivilege($currentUser, Rakuun_TeamSecurity::PRIVILEGE_USERDELETE)): ?>
		<? $useredit = new Rakuun_GUI_Control_UserDeleteLink('userdeletelink', $user, 'User löschen'); ?>
		<? $useredit->display() ?>
		<br class="clear" />
	<? endif;?>
	<? if (Rakuun_TeamSecurity::get()->hasPrivilege($currentUser, Rakuun_TeamSecurity::PRIVILEGE_MULTIHUNTING)): ?>
		<? $useredit = new Rakuun_GUI_Control_MultiLogLink('multiloglink', $user, 'Multilog anschauen'); ?>
		<? $useredit->display() ?>
		<br class="clear" />
	<? endif;?>
	
	<br class="clear" />
	<? if ($user->isInNoob()): ?>
		Der Spieler befindet sich im Noobschutz und kann nicht angegriffen werden.
		<br class="clear" />
	<? endif; ?>
	<? if ($user->isOnline()): ?>
		Der Spieler ist gerade online
		<br class="clear" />
	<? endif; ?>
	<? if ($user->isYimtay()): ?>
		Der Spieler war inaktiv und zum Yimtay geworden
		<br class="clear" />
	<? endif; ?>
<? else: ?>
	<br class="clear" />
	Spieler existiert nicht!
<? endif; ?>