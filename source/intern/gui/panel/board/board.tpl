<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<tr>
	<td><? $this->displayPanel('boardlink'); ?></td>
	<td class="posting_count"><?= $this->params->count; ?></td>
	<td>
		<? if ($this->hasPanel('date')): ?>
			<? $this->displayPanel('date'); ?>
		<? endif; ?>
	</td>
</tr>