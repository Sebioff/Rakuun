<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<? if ($this->hasPanel('graph_'.$this->getName())): ?>
	<? $this->displayPanel('graph_'.$this->getName()); ?>
<? else: ?>
	Noch nicht genug Daten für eine Grafik.
<? endif; ?>