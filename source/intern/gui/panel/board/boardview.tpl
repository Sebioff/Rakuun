<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? else: ?>
	<? if (isset($this->params->boardname)): ?>
		<? $this->displayPanel($this->params->boardname); ?>
	<? else: ?>
		<table summary="Forenübersicht" class="boardview">
			<thead>
				<tr>
					<td>Name</td>
					<td>Beiträge</td>
					<td>Letzter Beitrag</td>
				</tr>
			</thead>
			<tbody>
				<? foreach ($this->panels as $panel): ?>
					<? if (preg_match('=^board_(\d)+$=', $panel->getName())): ?>
						<? $panel->display(); ?>
					<? endif; ?>
				<? endforeach; ?>
			</tbody>
		</table>
		<hr />
		<? $this->displayPanel('addboard'); ?>
	<? endif; ?>
<? endif; ?>