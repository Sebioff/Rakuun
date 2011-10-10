<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
Arbeiter: <?= Text::formatNumber($this->getProductionItem()->getWorkers()); ?>/<?= Text::formatNumber($this->getProductionItem()->getRequiredWorkers()); ?>
<br />
<? $this->displayPanel('workers_add_amount'); ?> <? $this->displayPanel('workers_add'); ?>
<br />
<? $this->displayPanel('workers_remove_amount'); ?> <? $this->displayPanel('workers_remove'); ?>