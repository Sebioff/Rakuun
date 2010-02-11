<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? else: ?>
	<h2><?= $this->params->boardname; ?></h2>
	<ul>
		<? foreach ($this->panels as $panel): ?>
			<? if (preg_match('=^posting_(\d)+$=', $panel->getName())): ?>
				<? $panel->display(); ?>
			<? endif; ?>
		<? endforeach; ?>
	</ul>	
<? endif; ?>
<? $this->displayPanel('addposting'); ?>