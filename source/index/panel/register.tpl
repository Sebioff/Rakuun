<div id="registrationform">
	Hinweis: Dies ist eine Testversion, in der
	<br class="clear" />
	noch einige Funktionen fehlen und
	<br class="clear" />
	die	insbesondere nicht so aussieht wie die
	<br class="clear" />
	fertige Version aussehen soll. Falls Fehler
	<br class="clear" />
	auftreten gibt es keine Erstattungen.
	<br class="clear" />
	<br class="clear" />
	<? if ($this->hasErrors()): ?>
		<? $this->displayErrors() ?>
	<? endif ?>
	<? $this->displayLabelForPanel('username') ?> <? $this->displayPanel('username') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('password') ?> <? $this->displayPanel('password') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('password_repeat') ?> <? $this->displayPanel('password_repeat') ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('mail') ?> <? $this->displayPanel('mail') ?>
	<br class="clear" />
	<? $this->displayPanel('base64') ?>
	<? $this->displayPanel('submit') ?>
</div>