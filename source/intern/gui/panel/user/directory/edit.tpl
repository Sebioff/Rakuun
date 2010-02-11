<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if (!empty($this->params->lists)): ?>
	<ul>
		<? foreach ($this->params->lists as $list): ?>
			<li>
				<? $userLink = new Rakuun_GUI_Control_UserLink('userlink'.$list['assoc']->user->getPK(), $list['assoc']->user); ?>
				<? $userLink->display(); ?>
				<? $list['list']->display() ?>
			</li>
		<? endforeach; ?>
	</ul>
	<? $this->displayPanel('safe'); ?>
<? endif; ?>
<hr class="clear" />
<? $this->displayLabelForPanel('groupname'); ?>
<? $this->displayPanel('groupname'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>