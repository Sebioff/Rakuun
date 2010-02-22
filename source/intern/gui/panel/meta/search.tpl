<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $this->displayLabelForPanel('name') ?> <? $this->displayPanel('name') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors() && count($this->params->metas)): ?>
	<br class="clear" />
	<ul>
		<? foreach ($this->params->metas as $meta): ?>
			<li>
				<? $memberPanel = new Rakuun_GUI_Control_MetaLink('metalink', $meta, 'Profil anzeigen'); ?>
				<? $memberPanel->display() ?>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>