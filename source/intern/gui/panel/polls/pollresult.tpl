<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('question'); ?>
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