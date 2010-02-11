Arbeiter: <?= GUI_Panel_Number::formatNumber($this->getProductionItem()->getWorkers()); ?>/<?= GUI_Panel_Number::formatNumber($this->getProductionItem()->getRequiredWorkers()); ?>
<br />
<? $this->displayPanel('workers_add_amount'); ?> <? $this->displayPanel('workers_add'); ?>
<br />
<? $this->displayPanel('workers_remove_amount'); ?> <? $this->displayPanel('workers_remove'); ?>