<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayLabelForPanel('name'); ?> <? $this->displayPanel('name'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors() && count($this->params->users)): ?>
	<br class="clear" />
	<ul>
		<? foreach ($this->params->users as $user): ?>
			<li>
				<? $memberPanel = new Rakuun_GUI_Control_UserLink('userlink', $user, 'Profil anzeigen'); ?>
				<? $memberPanel->display(); ?>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>