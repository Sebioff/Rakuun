<? if ($this->hasMessages()): ?>
	<? $this->displayMessages() ?>
<? endif; ?>
<? if (Rakuun_User_Manager::getCurrentUser()->getDatabaseCount() > 0): ?>
	<p style="color: red">Du verteidigst ein Datenbankteil für deine Allianz und kannst dich daher nicht löschen.</p><br class="clear" />
<? endif; ?>
Um den Account zu löschen ist dein Passwort notwendig:
<br class="clear" />
<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
<br class="clear" />
Wir arbeiten ständig an der Verbesserung des Spiels und sind an jedem Hinweis, der uns hierbei hilft, sehr interessiert. Falls du uns hier noch irgendwelche Verbesserungsvorschläge oder den Grund für deine Accountlöschung mitteilen willst, würden wir uns darüber sehr freuen.
<br class="clear" />
<? $this->displayLabelForPanel('text'); ?> <? $this->displayPanel('text'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>