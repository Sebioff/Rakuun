<? foreach ($this->getPanelsForDefendingUnits() as $panel): ?>
	<? $panel->display(); ?>
<? endforeach; ?>
<hr/>
<? foreach ($this->getPanelsForOtherUnits() as $panel): ?>
	<? $panel->display(); ?>
<? endforeach; ?>
