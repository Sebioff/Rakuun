<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('refresh'); ?>
<hr />
<? foreach ($this->panels as $panel): ?>
	<? if (strpos($panel->getName(), 'shout_') === 0): ?>
		<? $panel->display(); ?>
		<hr/>
	<? endif; ?>
<? endforeach; ?>
<? if ($this->getPageCount() > 1): ?>
	<? $this->displayLabelForPanel('pages'); ?>: <? $this->displayPanel('pages'); ?>
	<hr />
<? endif; ?>
<? $this->displayPanel('shoutarea'); ?>
<br class="clear" />
<span style="float:left">Buchstaben übrig:</span> <input id="shoutbox_characters_left" type="text" size="3" value="<?= Rakuun_Intern_GUI_Panel_Shoutbox::SHOUT_MAX_LENGTH; ?>" readonly="readonly" /><? $this->displayPanel('submit'); ?>