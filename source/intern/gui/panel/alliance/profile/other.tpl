<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->hasPanel('image')): ?>
	<? $this->displayPanel('image'); ?>
<? endif; ?>
Allianz "<?= $this->params->alliance->name ?>"

<h2>Allianzbeschreibung:</h2>
<?= $this->params->alliance->description ?>
<? $this->displayPanel('memberbox') ?>
<br class="clear" />
<? $this->displayPanel('databases') ?>
<br class="clear" />
<? if ($this->hasPanel('application')): ?>
	<? $this->displayPanel('application'); ?>
<? endif; ?>
<? $this->displayPanel('diplomacy'); ?>