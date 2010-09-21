<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
	<br class="clear" />
<? endif; ?>
<? $leaderNames = array(); ?>
<? foreach (Rakuun_Intern_Alliance_Security::getForAlliance($this->params->alliance)->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS) as $leader): ?>
	<? $leaderNames[] = $leader->name; ?>
<? endforeach; ?>
Leiter: <?= implode(', ', $leaderNames); ?>
<br/>
<h2>Allianzbeschreibung:</h2>
<p><?= $this->params->alliance->description ? $this->params->alliance->description : 'Keine Beschreibung.'; ?></p>

<h2>Interne Beschreibung:</h2>
<p><?= $this->params->alliance->intern ? $this->params->alliance->intern : 'Keine Beschreibung.'; ?></p>

<? $this->displayPanel('account'); ?>
<br class="clear" />
<? $this->displayPanel('deposit'); ?>
<br class="clear" />
<? $this->displayPanel('leave'); ?>
<br class="clear" />
<? if ($this->hasPanel('activity')): ?>
	<? $this->displayPanel('activity'); ?>
	<br class="clear" />
<? endif; ?>