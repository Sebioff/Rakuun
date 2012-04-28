<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div id="ctn_rakuun_alliance_none">
	<?= $this->displayPanel('search'); ?>
	<? if ($this->hasPanel('found')): ?>
		<br class="clear" />
		<?= $this->displayPanel('found'); ?>
	<? endif; ?>
</div>