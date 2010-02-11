<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayLabelForPanel('question'); ?> <? $this->displayPanel('question'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('runtime'); ?> <? $this->displayPanel('runtime'); ?>
<br class="clear" />
<? for ($i = 0; $i < $_SESSION['poll-answer-count']; $i++): ?>
	<? $this->displayLabelForPanel('answer'.$i); ?> <? $this->displayPanel('answer'.$i); ?>
	<br class="clear" />
<? endfor; ?>
<? $this->displayPanel('submit'); ?>
<? $this->displayPanel('addanswer'); ?>