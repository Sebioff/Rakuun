<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<tr>
	<td><a href="<?= Router::get()->getCurrentModule()->getUrl(array('board' => $this->params->board->id)) ?>"><?= Text::escapeHTML($this->params->board->name) ?></a></td>
	<td class="posting_count"><?= $this->params->count; ?></td>
	<td>
		<? if ($this->hasPanel('date')): ?>
			<? $this->displayPanel('date'); ?>
		<? endif; ?>
	</td>
</tr>