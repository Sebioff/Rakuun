<? if ($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>
<? if (!empty($this->params->members)): ?>
	<dl>
	<? foreach ($this->params->members as $member): ?>
		<dt>
			<? $memberPanel = new Rakuun_GUI_Control_UserLink('member_'.$member->id, $member); ?>
			<? $memberPanel->display() ?>			
		</dt>
		<dd>
			<? $this->displayPanel('blanko'.$member->getPK()); ?>
		</dd>
	<? endforeach ?>
	</dl>
<? endif ?>