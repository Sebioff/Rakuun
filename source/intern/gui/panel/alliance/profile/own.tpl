<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
	<br class="clear" />
<? endif; ?>
<h2>Allianzbeschreibung:</h2>
<p><?= $this->params->alliance->description ? $this->params->alliance->description : 'Keine Beschreibung.' ?></p>

<h2>Interne Beschreibung:</h2>
<p><?= $this->params->alliance->intern ? $this->params->alliance->intern : 'Keine Beschreibung.' ?></p>

<? $this->displayPanel('account'); ?>
<br class="clear" />
<? $this->displayPanel('deposit'); ?>
<br class="clear" />
<? $this->displayPanel('leave'); ?>
<br class="clear" />
<? if ($this->hasPanel('delete')): ?>
	<? $this->displayPanel('delete'); ?>
	<br class="clear" />
<? endif; ?>
<? if ($this->hasPanel('activity')): ?>
	<? $this->displayPanel('activity'); ?>
	<br class="clear" />
<? endif; ?>