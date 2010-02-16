<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
	<br class="clear" />
<? endif; ?>
<h2>Allianzbeschreibung:</h2>
<p><?= $this->params->alliance->description ? $this->params->alliance->description : 'Keine Beschreibung.' ?></p>

<h2>Interne Beschreibung:</h2>
<p><?= $this->params->alliance->intern ? $this->params->alliance->intern : 'Keine Beschreibung.' ?></p>

<? $this->displayPanel('leave'); ?>
<? if ($this->hasPanel('delete')): ?>
	<? $this->displayPanel('delete'); ?>
<? endif; ?>
<br class="clear" />
<? $this->displayPanel('account'); ?>
<? $this->displayPanel('deposit'); ?>
<? if ($this->hasPanel('activity')): ?>
	<br class="clear" />
	<? $this->displayPanel('activity'); ?>
<? endif; ?>