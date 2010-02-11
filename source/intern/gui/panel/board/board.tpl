<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<tr>
	<td><a href="<?= Router::get()->getCurrentModule()->getUrl(array('board' => $this->params->board->id)) ?>"><?= Text::escapeHTML($this->params->board->name) ?></a></td>
	<td class="posting_count"><?= $this->params->count; ?></td>
	<td><? $this->displayPanel('date'); ?></td>
</tr>