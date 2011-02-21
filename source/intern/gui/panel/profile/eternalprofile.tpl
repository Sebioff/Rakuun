<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayLabelForPanel('round'); ?> <? $this->displayPanel('round'); ?>
<br class="clear"/>
<? $this->displayLabelForPanel('username'); ?> <? $this->displayPanel('username'); ?>
<br class="clear"/>
<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
<br class="clear"/>
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