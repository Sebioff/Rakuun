<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
Eisen: <?= $this->getIronCosts() ?>
<br />
Beryllium: <?= $this->getBerylliumCosts() ?>
<br />
<? $this->displayLabelForPanel('name') ?> <? $this->displayPanel('name') ?>
<br class="clear" />
<? $this->displayLabelForPanel('tag') ?> <? $this->displayPanel('tag') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>