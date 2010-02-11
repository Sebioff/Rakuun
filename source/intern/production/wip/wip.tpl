<? if ($this->getWIPItem() instanceof Rakuun_Intern_Production_CityItem): ?>
	<?= $this->getWIPItem()->getName() ?> (Stufe <?= $this->getLevel() ?>) - Dauer: <?= Rakuun_Date::formatCountDown($this->getTimeCosts()) ?>
<? else: ?>
	<?= $this->getWIPItem()->getName() ?> (x<?= GUI_Panel_Number::formatNumber($this->getAmount()) ?>) - Dauer: <?= Rakuun_Date::formatCountDown($this->getTimeCosts()) ?>
<? endif; ?>
<? if ($this->hasPanel('move_up')): ?>
	<? $this->displayPanel('move_up'); ?>
<? endif; ?>
<? if ($this->hasPanel('move_down')): ?>
	<? $this->displayPanel('move_down'); ?>
<? endif; ?>