<? $this->displayPanel('workers_ironmine'); ?>
<? $this->displayPanel('workers_berylliummine'); ?>
<br class="clear" />
<? if ($this->hasPanel('workers_clonomat')): ?>
	<? $this->displayPanel('workers_clonomat'); ?>
<? endif; ?>
<? if ($this->hasPanel('workers_hydropower_plant')): ?>
	<? $this->displayPanel('workers_hydropower_plant'); ?>
<? endif; ?>
<br class="clear" />
<br />
<a href="<?= App::get()->getInternModule()->getSubmodule('build')->getUrl(); ?>">Zurück</a>