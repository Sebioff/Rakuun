<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? if (!empty($this->params->alliances)): ?>
	<dl>
	<? foreach ($this->params->alliances as $alliance): ?>
		<dt>
			<? $allianceLink = new Rakuun_GUI_Control_AllianceLink('alliance'.$alliance->getPK(), $alliance); ?>
			<? $allianceLink->display() ?>			
		</dt>
		<dd>
			<? $this->displayPanel('blanko'.$alliance->getPK()); ?>
		</dd>
	<? endforeach; ?>
	</dl>
<? endif; ?>