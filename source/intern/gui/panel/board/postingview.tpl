<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<h2 class="rakuun_board_name">Forum -> <?= $this->params->boardname; ?></h2>
<? if ($this->hasPanel('moderatelink')): ?>
	<? $this->displayPanel('moderatelink'); ?>
<? endif; ?>
<? $this->displayPanel('board'); ?>
<? $this->displayPanel('post'); ?>