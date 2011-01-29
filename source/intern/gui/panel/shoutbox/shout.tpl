<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->params->shout->get('user') != Rakuun_Intern_GUI_Panel_Shoutbox::ANNOUNCER_USERID): ?>
	<div class="shout_header">
		<? $this->displayPanel('userlink'); ?>, am <? $this->displayPanel('date'); ?>
		<? if ($this->hasPanel('answerlink')): $this->displayPanel('answerlink'); endif; ?>
		<? if ($this->hasPanel('moderate')): ?>
			<? $this->displayPanel('moderate'); ?>
		<? endif; ?>
	</div>
<div class="shout_text">
<? else: ?>
	<div class="shout_text shout_announcement">
<? endif; ?>
	<?= Rakuun_Text::formatPlayerText($this->params->shout->text); ?>
</div>