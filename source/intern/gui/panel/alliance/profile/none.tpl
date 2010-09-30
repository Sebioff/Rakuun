<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<div id="ctn_rakuun_alliance_none">
	<?= $this->displayPanel('search'); ?>
	<br class="clear" />
	<?= $this->displayPanel('found'); ?>
</div>