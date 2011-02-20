<div id="ctn_messages_top">
	<? $this->displayPanel('categories') ?>
	<? if ($this->hasPanel('message')): $this->displayPanel('message'); endif;?>
	<? if ($this->hasPanel('reply')): $this->displayPanel('reply'); endif; ?>
	<? if ($this->hasPanel('history')): $this->displayPanel('history'); endif; ?>
	<? if ($this->hasPanel('ticket')): $this->displayPanel('ticket'); endif; ?>
	<? if ($this->hasPanel('replyticket')): $this->displayPanel('replyticket'); endif; ?>
</div>