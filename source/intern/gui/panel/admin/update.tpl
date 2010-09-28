<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? $this->displayPanel('create_news'); ?>
<? if ($this->hasPanel('newstext')): ?>
	<br class="clear"/>
	<? $this->displayLabelForPanel('newstext'); ?> <? $this->displayPanel('newstext'); ?>
	<br class="clear"/>
	<? $this->displayLabelForPanel('tweet'); ?> <? $this->displayPanel('tweet'); ?>
	<br class="clear"/>
	<span style="float:left">Buchstaben übrig:</span> <input id="shoutbox_characters_left" type="text" size="3" value="140" readonly="readonly" />
<? elseif($this->state->getValue() == Rakuun_Intern_GUI_Panel_Admin_Update::STATE_REVIEWING): ?>
	<br class="clear"/>
	Es wird kein Newseintrag erstellt.
<? endif; ?>
<? $this->displayPanel('update'); ?>
<br />
<? if (isset($this->params->conflicts) && $this->params->conflicts): ?>
	<span style="color:#ff0000; font-weight:bold">Es gab Konflikte beim Updaten!</span>
	<br/>
<? endif; ?>
<? $this->displayPanel('update_log'); ?>
<? $this->displayPanel('state'); ?>
<br class="clear"/>