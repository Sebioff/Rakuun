<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif; ?>
<? $this->displayPanel('poolbox'); ?>
<? $this->displayPanel('displaybox'); ?>
<br class="clear" />
<? $this->displayPanel('buyironbox'); ?>
<? $this->displayPanel('sellironbox'); ?>
<br class="clear" />
<? $this->displayPanel('buyberylliumbox'); ?>
<? $this->displayPanel('sellberylliumbox'); ?>
<br class="clear" />
<? $this->displayPanel('buyenergybox'); ?>
<? $this->displayPanel('sellenergybox'); ?>