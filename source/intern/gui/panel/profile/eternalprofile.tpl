<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayLabelForPanel('round'); ?> <? $this->displayPanel('round'); ?>
<br class="clear"/>
<? $this->displayLabelForPanel('username'); ?> <? $this->displayPanel('username'); ?>
<br class="clear"/>
<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
<br class="clear"/>
<? $this->displayPanel('state'); ?>
<? if ($this->state->getValue() == Rakuun_Intern_GUI_Panel_Profile_EternalProfile::STATE_CONFIRM): ?>
	Die Leistungen aus dieser Runde wurden bereits einem anderen ewigen Profil hinzugefügt.
	<br/>
	Willst du die Leistungen aus dem anderen ewigen Profil löschen und zu diesem hinzufügen?
	<br/>
<? endif; ?>
<? $this->displayPanel('add'); ?>
<? if ($this->params->linkedProfiles): ?>
	<hr/>
	<h3>Verbundene Profile</h3>
	<ul>
		<? foreach ($this->params->linkedProfiles as $linkedProfileName): ?>
			<li>
				<?= $linkedProfileName; ?>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>