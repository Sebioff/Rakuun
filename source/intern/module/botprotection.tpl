<? if ($this->hasMessages()): ?>
	<? $this->displayMessages() ?>
<? endif; ?>

<? // TODO dont forget to style this, looks ugly ;). Also, add some nice explanation why this protection is neccessary ?>
<? $this->displayPanel('captcha'); ?>
<? $this->displayPanel('submit'); ?>

Diese Überprüfung findet alle <?= Rakuun_Date::formatCountDown(Rakuun_Intern_Module::TIMEOUT_BOTVERIFICATION); ?> statt.