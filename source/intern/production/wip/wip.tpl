<? if ($this->getWIPItem() instanceof Rakuun_Intern_Production_CityItem): ?>
	<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $this->getWIPItem()->getType(), 'id' => $this->getWIPItem()->getInternalName())); ?>"><?= $this->getWIPItem()->getName(); ?></a> (Stufe <?= $this->getLevel(); ?>) - Dauer: <?= Rakuun_Date::formatCountDown($this->getTimeCosts()); ?>
<? else: ?>
	<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $this->getWIPItem()->getType(), 'id' => $this->getWIPItem()->getInternalName())); ?>"><?= $this->getWIPItem()->getName(); ?></a> (x<?= GUI_Panel_Number::formatNumber($this->getAmount()); ?>) - Dauer: <?= Rakuun_Date::formatCountDown($this->getTimeCosts()); ?>
<? endif; ?>
<div class="controls">
	<? if ($this->hasPanel('move_up')): ?>
		<? $this->displayPanel('move_up'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('move_down')): ?>
		<? $this->displayPanel('move_down'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('cancel')): ?>
		<? $this->displayPanel('cancel'); ?>
	<? endif; ?>
</div>