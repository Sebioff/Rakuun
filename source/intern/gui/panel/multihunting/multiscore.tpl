<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<? $this->displayPanel('multiscore'); ?>
	<? if ($this->getPageCount() > 1): ?>
		<hr/>
		<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
	<? endif; ?>
</div>