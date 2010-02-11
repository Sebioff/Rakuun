<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('userlink'); ?>, am <? $this->displayPanel('date'); ?>
, <? $this->displayPanel('answerlink'); ?>
<br class="clear" />
<div class="shout_text">
	<?= nl2br(Text::escapeHTML($this->params->shout->text)); ?>
</div>