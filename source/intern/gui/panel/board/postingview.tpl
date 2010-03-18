<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<h2 class="rakuun_board_name">Forum -> <?= $this->params->boardname; ?></h2>
<? $this->displayPanel('board'); ?>
<? $this->displayPanel('post'); ?>