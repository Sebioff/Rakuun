<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif ?>
<p>Eine neue diplomatische Beziehung kann erst eingegangen werden,<br />wenn aktuell keine Beziehung zwischen den Allianzen besteht.</p>
<? $this->displayLabelForPanel('alliances'); ?> <? $this->displayPanel('alliances'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('type'); ?> <? $this->displayPanel('type'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('notice'); ?> <? $this->displayPanel('notice'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('text'); ?> <? $this->displayPanel('text'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>