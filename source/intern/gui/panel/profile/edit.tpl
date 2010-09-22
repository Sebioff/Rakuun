<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->hasPanel('namecolored')): ?>
	<? $this->displayLabelForPanel('namecolored'); ?> <? $this->displayPanel('namecolored'); ?> <? $this->displayPanel('namecoloredhelp'); ?>
	<br class="clear" />
<? endif; ?>
<? $this->displayLabelForPanel('cityname'); ?> <? $this->displayPanel('cityname'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('icq'); ?> <? $this->displayPanel('icq'); ?>
<? if ($this->hasPanel('description')): ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('description'); ?> <? $this->displayPanel('description'); ?>
<? endif;?>
<br class="clear" />
<? $this->displayLabelForPanel('skin'); ?> <? $this->displayPanel('skin'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('mail'); ?> <? $this->displayPanel('mail'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('sitter'); ?> <? $this->displayPanel('sitter'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('picture'); ?> <? $this->displayPanel('picture'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('tutorial'); ?> <? $this->displayPanel('tutorial'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>