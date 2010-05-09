<div class="rakuun_board_postinfo">
	<? $this->displayPanel('user'); ?>, am <? $this->displayPanel('date'); ?>
	<? if ($this->hasPanel('editlink')): ?>
		<? $this->displayPanel('editlink'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('delete')): ?>
		<? $this->displayPanel('delete'); ?>
	<? endif; ?>
	<br />
</div>
<div class="rakuun_board_postcontent">
	<? if ($this->params->posting->deleted == 1): ?>
		<? if ($this->params->config->getIsGlobal()): ?>
			<? if ($this->params->posting->deletedByRoundNumber == RAKUUN_ROUND_NAME): ?>
				<? $delUser = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->params->posting->deletedByName); ?>
				<? $delUserLink = new Rakuun_GUI_Control_UserLink('user', $delUser, $delUser->getPK()); ?>
			<? else: ?>
				<? $delUserLink = new GUI_Panel_Text('user', $this->params->posting->deletedByName.' ['.$this->params->posting->deletedByRoundNumber.']'); ?>
			<? endif; ?>
		<? else: ?>
			<? $delUserLink = new Rakuun_GUI_Control_Userlink('user', $this->params->posting->deletedBy, $this->params->posting->get('deleted_by')); ?>
		<? endif; ?>
	<i>
		Dieser Beitrag wurde von <? $delUserLink->display(); ?> gelöscht!<br />
		Er wird nur noch den Moderatoren und dem Autor angezeigt.<br />
	</i>
	<? endif; ?>
	<? if ($this->checkDisplayPosting()): ?>
		<? if ($this->hasPanel('form')): ?>
			<? $this->displayPanel('form'); ?>
		<? else: ?>
			<?=  Text::format(Text::escapeHTML($this->params->posting->text)); ?>
			<? if ($this->hasPanel('editdate')): ?>
			<br />
			<i>
				last edit:
				<? $this->displayPanel('editdate'); ?>
			</i>
			<? endif; ?>
		<? endif; ?>
	<? endif; ?>
</div>
<hr/>