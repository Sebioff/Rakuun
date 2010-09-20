<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('question'); ?>
<? if ($this->hasPanel('delete')): ?>
	<? $this->displayPanel('delete'); ?>
<? endif; ?>
<ul>
	<? for ($i = 0; $i < $this->params->anz; $i++): ?>
		<li>
			<? $this->displayPanel('answer'.$i); ?>:
			<? $this->displayPanel('count'.$i); ?>
			(<? $this->displayPanel('percent'.$i); ?>%)
		</li>
	<? endfor; ?>
	<li>
		<? $this->displayPanel('plot'); ?>
	</li>
</ul>