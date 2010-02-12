<? if($this->hasErrors()): ?>
	<li>
		<? $this->displayErrors(); ?>
	</li>
<? endif ?>
<li>
	<div class="rakuun_board_postinfo">
		<? $this->displayPanel('date'); ?><br />
		<? $this->displayPanel('user'); ?>:
		<? if ($this->hasPanel('editlink')): ?>
			<? $this->displayPanel('editlink'); ?>
		<? endif; ?>
		<br />
	</div>
	<div class="rakuun_board_postcontent">
		<? if ($this->hasPanel('submit')): ?>
			<? $this->displayPanel('text'); ?>
			<br class="clear" />
			<? $this->displayPanel('submit'); ?>
		<? else: ?>
			<?= Text::escapeHTML($this->params->posting->text); ?>
			<? if ($this->hasPanel('editdate')): ?>
			<br />
			<i>
				last edit:
				<? $this->displayPanel('editdate'); ?>
			</i>
			<? endif; ?>
		<? endif; ?>
	</div>
</li>