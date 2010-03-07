<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<h2><?= $this->params->boardname; ?></h2>
<? $this->displayPanel('board'); ?>
<? $this->displayPanel('post'); ?>