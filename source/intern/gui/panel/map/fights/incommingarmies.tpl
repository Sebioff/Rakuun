<? foreach ($this->getArmiesPanels() as $armyPanelArray): ?>
	Angriff durch <?= $armyPanelArray['army']->user->name; ?> in <? $armyPanelArray['countdownPanel']->display(); ?>
	<br/>
<? endforeach; ?>