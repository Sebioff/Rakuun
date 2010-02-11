<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $this->displayLabelForPanel('name') ?> <? $this->displayPanel('name') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors() && count($this->params->alliances)): ?>
	<br class="clear" />
	<ul>
		<? foreach ($this->params->alliances as $alliance): ?>
			<? $link = new Rakuun_GUI_Control_AllianceLink('link'.$alliance->getPK(), $alliance); ?>
			<li><? $link->display(); ?></li>
		<? endforeach; ?>
	</ul>
<? endif; ?>