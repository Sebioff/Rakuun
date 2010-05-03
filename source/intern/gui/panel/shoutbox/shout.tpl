<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div class="shout_header">
<? $this->displayPanel('userlink'); ?>, am <? $this->displayPanel('date'); ?>
, <? if ($this->hasPanel('answerlink')): $this->displayPanel('answerlink'); endif; ?>
	<? if ($this->hasPanel('moderate')): ?>
		<? $this->displayPanel('moderate'); ?>
	<? endif; ?>
</div>
<div class="shout_text">
	<?= Text::format((Text::escapeHTML($this->params->shout->text))); ?>
</div>