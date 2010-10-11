<? foreach ($this->getPanelsForDefendingUnits() as $panel): ?>
	<? $panel->display(); ?>
	<br class="clear"/>
<? endforeach; ?>
<hr/>
<? foreach ($this->getPanelsForOtherUnits() as $panel): ?>
	<? $panel->display(); ?>
	<br class="clear"/>
<? endforeach; ?>
