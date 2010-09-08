<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->hasPanel('image')): ?>
	<? $this->displayPanel('image'); ?>
<? endif; ?>
Allianz "<?= $this->params->alliance->name; ?>"
<br/>
<? $leaderNames = array(); ?>
<? foreach (Rakuun_Intern_Alliance_Security::getForAlliance($this->params->alliance)->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS) as $leader): ?>
	<? $leaderNames[] = $leader->name; ?>
<? endforeach; ?>
Leiter: <?= implode(', ', $leaderNames); ?>

<h2>Allianzbeschreibung:</h2>
<?= $this->params->alliance->description; ?>
<? $this->displayPanel('memberbox'); ?>
<br class="clear" />
<? $this->displayPanel('databases'); ?>
<br class="clear" />
<? if ($this->hasPanel('application')): ?>
	<? $this->displayPanel('application'); ?>
<? endif; ?>
<? $this->displayPanel('diplomacy'); ?>