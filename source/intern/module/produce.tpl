<? if (Rakuun_User_Manager::isSitting()): ?>
	<center>Herstellungskosten sind im Sittmodus um <?= (Rakuun_Intern_Production_Base::SITTER_PRODUCTION_COSTS_MULTIPLIER - 1) * 100; ?>% erhöht.</center>
<? endif; ?>
<? $this->displayPanel('wip'); ?>
<br class="clear" />
<? if ($this->hasPanel('information')): ?>
	<? $this->displayPanel('information'); ?>
<? endif; ?>
<? $this->displayPanel('sortpane'); ?>