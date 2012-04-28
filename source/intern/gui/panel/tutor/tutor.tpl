<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('detlef'); ?>
<div id="ctn_tutor_content">
	<?= $this->params->level->getDescription(); ?>
</div>
<div id="ctn_tutor_controls">
	Schritt <?= $this->getCurrentLevelNumber(); ?> von <?= $this->getLevelCount(); ?> -
	<? if ($this->params->level->completed()): ?>
		<span class="rakuun_requirements_met">Erledigt</span>
	<? else: ?>
		<span class="rakuun_requirements_failed">Nicht erledigt</span>
	<? endif; ?>
	<? if ($this->hasPanel('first')): ?>
		<? $this->displayPanel('first'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('back')): ?>
		<? $this->displayPanel('back'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('next')): ?>
		<? $this->displayPanel('next'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('last')): ?>
		<? $this->displayPanel('last'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('end')): ?>
		<? $this->displayPanel('end'); ?>
	<? endif; ?>
</div>
<br class="clear" />