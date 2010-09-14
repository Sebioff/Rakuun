<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<? $this->displayPanel('highscore'); ?>
	<? if ($this->getPageCount() > 1): ?>
		<hr/>
		<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
	<? endif; ?>
</div>
